<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models
 * @mixin \Eloquent
 */
class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'logo',
    ];

    /**
     * The attributes to append.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Select if return the categories family tree.
     *
     * @var bool
     */
    protected $family_tree = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product')->where('is_show', 1)->orderBy('weight', 'desc');
    }

    public function category()
    {
        return $this->hasMany('App\Models\Category');
    }

    /**
     * Return a collection of a category's childs, or null if don't have.
     *
     * @return collection
     */
    public function getChilds()
    {
        $childs = $this->hasMany('App\Models\Category')->orderBy('name')->get();
        if (!count($childs)) {
            $childs = null;
        } elseif ($this->family_tree) {
            $childs->each(function ($cat) {
                $cat->withFamilyTree();
            });
        }

        return $childs;
    }

    /**
     * Return the parent of a category, or null if don't have.
     *
     * @return category model
     */
    public function getParent()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->first();
    }

    /**
     * Return the the full tree of parents of a category, or null if don't have.
     * The tree contains the master parent, and a child attribute that contains next element,
     * up to.
     *
     * @return category model
     */
    public function getParentTree()
    {
        if (!$this->hasParent()) {
            return;
        }
        //family tree (return all category parents)
        $tree = $this->parent;
        $tree->child = null;
        while ($tree->hasParent()) {
            $new = $tree->parent;
            $new->child = $tree;
            $tree = $new;
        }

        return $tree;
    }

    public function hasChilds()
    {
        return (bool)count($this->childs);
    }

    public function hasChildren()
    {
        return isset($this->children) && count($this->children);
    }

    public function hasParent()
    {
        return (bool)count($this->parent);
    }

    public function withChilds()
    {
        return $this;
    }

    public function withFamilyTree()
    {
        $children = self::childsOf($this->id)->get();
        if ($children->count()) {
            $this->children = $children->buildTree();
        }

        return $this;
    }

    public function withParentTree()
    {
        if (!in_array('parent_tree', $this->appends)) {
            $this->appends[] = 'parent_tree';
        }

        return $this;
    }

    public function scopeSearch($query, $name)
    {
        if (trim($name) != '') {
            $query->where('name', 'LIKE', "%$name%");
        }
    }

    public function scopeByName($query)
    {
        return $query->orderBy('name');
    }

    public function scopeActives($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactives($query)
    {
        return $query->where('status', 0);
    }

    /**
     * scopeChildsOf
     * Return all the children of a category. If the id is empty, 'parents' or 'others' will be given.
     *
     * @param  $query
     * @param  $id that can be either category id, empty value, 'parents' or 'mothers'
     *
     * @return $query
     */
    public function scopeChildsOf($query, $id)
    {
        if (!$id || $id == 'parent' || $id == 'mothers') {
            return $query->whereNull('category_id');
        } else {
            return $query->where('category_id', $id);
        }
    }

    /**
     * scopeMothers
     * Retrieve the main categories.
     *
     * @param [type] $query [description]
     *
     * @return [type] [description]
     */
    public function scopeMothers($query)
    {
        return $query->whereNull('category_id');
    }

    /**
     * scopeFull
     * Retrieve the total of products contained in a category.
     *
     * @param [type] $query [description]
     *
     * @return [type] [description]
     */
    public function scopeFull($query)
    {
        return $query->where(\DB::raw(0), '<', function ($sql) {
            $sql->select(\DB::raw('COUNT(products.id)'))->from('products')->whereRaw('categories.id=products.category_id');
        });
    }

    /**
     * scopeLightSelection
     * Retrieve build the query select as scope.
     *
     * @param [object] $query contains the Laravel query builder
     */
    public function scopeLightSelection($query)
    {
        return $query->select('categories.id', 'categories.name', 'categories.category_id');
    }

    /**
     * progeny
     * Retrieve all the categories children of one passed through parameter,
     * checking data from bottom to top.
     *
     * @param [int]   $id     is the id category evaluated
     * @param [array] $array  is the array to be used out of the model
     * @param [array] $fields is the array that contais the table field we want to retrieve
     */
    public static function progeny($id, &$list, $fields = ['id', 'name'])
    {
        $childs = self::childsOf($id)->select($fields)->get();

        if (is_null($childs)) {
            return;
        }

        foreach ($childs as $value) {
            $list[] = $value->toArray();

            self::progeny($value->id, $list, $fields);
        }
    }

    /**
     * parentsTree
     * Retrieve all the categories parents of one passed through parameter,
     * checking data from bottom to top.
     *
     * @param [int]   $id     is the id category evaluated
     * @param [array] $array  is the array to be used out of the model
     * @param [array] $fields is the array that contais the table field we want to retrieve
     */
    public static function parentsTree($id, &$array, $fields = ['id', 'category_id', 'name'])
    {
        $categories = self::select($fields)
            ->where('id', $id)
            ->get()
            ->toArray();

        if (is_null($categories)) {
            return;
        }

        foreach ($categories as $value) {
            $array[] = $value;
            self::parentsTree($value['category_id'], $array, $fields);
        }
    }
}