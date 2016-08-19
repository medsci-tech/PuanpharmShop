/**
 * Created by Cheng Huang on 2016-04-19.
 */

;
(function ($) {
    "use strict";

    var $maskLayer = $('.mask-layer');

    function showMaskLayer(show) {
        return show ? $maskLayer.show() : $maskLayer.hide();
    }

    function showWindow($window, show) {
        if (show) {
            $window.css({
                bottom: '0'
            });
        } else {
            $window.css({
                bottom: '-1000%'
            });
        }
    }

    var $notify = $('.notify');

    function showNotify(text, timeout) {
        showMaskLayer(true);
        //$notify.fadeIn();
        $notify.find('.notify-inner').html(text);
        $notify.fadeIn();
        setTimeout(function () {
            $notify.fadeOut();
            showMaskLayer(false);
        }, timeout);

    }

    function validateForm(name, phone, province, city, district, address, zip) {
        // Todo
        if (!name || name.length < 2) {
            showNotify('请填写用户名！', 3000);
            return false;
        }

        if (!phone || !phone.length || !/^\d+$/.test(phone)) {
            showNotify('请填写电话号码！', 3000);
            return false;
        }

        if (!(/^1[3|4|5|7|8]\d{9}$/.test(phone))) {
            showNotify('手机号码有误！', 3000);
            return false;
        }
        // } else if(!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(phone)){
        //     showNotify('固话号码有误！', 3000);
        //     // return false;
        // } else {
        //     return false;
        // }

        if (!province || !province.length || province.indexOf('选择') !== -1) {
            showNotify('请选择省份！', 3000);
            return false;
        }

        if (!city || !city.length || city.indexOf('选择') !== -1) {
            showNotify('请选择城市！', 3000);
            return false;
        }


        if (district) {
            if (district.indexOf('选择') !== -1) {
                showNotify('请选择地区！', 3000);
                return false;
            }
        }

        if (!address || !address.length) {
            showNotify('请填写详细地址！', 3000);
            return false;
        }
        return true;
    }


    jQuery.fn.dragdrop = function (el) {
        this.bind('mousedown', function (e) {
            var relX = e.pageX - $(el).offset().left;
            var relY = e.pageY - $(el).offset().top;
            var maxX = $('body').width() - $(el).width() - 10;
            var maxY = $('body').height() - $(el).height() - 10;
            $(document).bind('mousemove', function (e) {
                var diffX = Math.min(maxX, Math.max(0, e.pageX - relX));
                var diffY = Math.min(maxY, Math.max(0, e.pageY - relY));
                $(el).css('left', diffX + 'px').css('top', diffY + 'px');
            });
        });
        $(window).bind('mouseup', function (e) {
            $(document).unbind('mousemove');
        });
        return this;
    };

    function Application() {
        var Main = {
            init: function () {
                this._initSlider();
                this._initSubmenus();
                //this._initIndexBuy();
                this._initTab();
                this._initUserActions();
                this._initCartActions();
                this._initAddressActions();
                // this._moveCartButton();
                this._handleCart();
                //this._fillIndex();
                this._handleDetail();
                this._handleAddress();
                this._handleAddressTasks();
                this._handlePayTasks();
                this._handleOrder();
                this._initOrderDetailActions();
                this._initWechatPayActions();
            },
            _initSlider: function () {
                if (typeof Swiper !== 'function') {
                    return;
                }
                var swiperConfig = {
                    pagination: '.swiper-pagination',
                    loop: true,
                    autoplay: 3000
                };
                var swiper = new Swiper('.swiper-container', swiperConfig);

                function reInitSwiper() {
                    setTimeout(function () {
                        swiper.destroy(true, true);
                        swiper = new Swiper('.swiper-container', swiperConfig);
                    }, 500);
                }


                $(window).resize(function () {
                    reInitSwiper();
                });


                $(window).on('orientationchange', function () {
                    reInitSwiper();
                })
            },
            _initSubmenus: function () {
                $('nav .menu').on('click', function (event) {
                    $(this).find('.sub-menu').toggle();
                    $(this).siblings().find('.sub-menu').fadeOut();

                    event.stopPropagation();
                });

                $(document.body).on('click', function () {
                    $('.sub-menu').fadeOut();
                });
            },
            //_initIndexBuy: function () {
            //    var $windowBuy = $('.window.buy');
            //    $('.product .buy').on('click', function (event) {
            //        var $parent = $(this).parents('.product');
            //        $windowBuy.find('.preview img').attr('src', $parent.find('.product-pic img').attr('src'));
            //        $windowBuy.find('.detail .title').text($parent.find('.product-name').text());
            //        var price = $parent.find('.product-price .price').text();
            //        price = price.substring(1, price.length);
            //        $windowBuy.find('.price .value').text(price);
            //        var productId = $parent.attr('id');
            //        $windowBuy.find('.quantum .quantity .txt').val(1);
            //        //$windowBuy.data('product_id', productId);
            //        //$windowBuy.find('#added-product-id').val(productId);
            //        $windowBuy.find('.added-product-id').val(productId.match(/\d+/)[0]);
            //
            //        var $input = $('<input type="hidden" class="quantum-submit" name="product_id[' + productId.match(/\d+/)[0] + ']" />');
            //        $windowBuy.find('form').append($input);
            //        showMaskLayer(true);
            //        //fillWindow($windowBuy);
            //        showWindow($windowBuy, true);
            //
            //        event.preventDefault();
            //    });
            //
            //    $windowBuy.find('.btn.buy-now').on('click', function () {
            //        var quantum = $windowBuy.find('.quantum .quantity .txt').val();
            //        $windowBuy.find('form .quantum-submit').val(quantum);
            //    })
            //
            //    $('.window-title .close').on('click', function () {
            //        showMaskLayer(false);
            //        showWindow($(this).parents('.window'), false);
            //    });
            //},
            _initTab: function () {
                var $tabBtns = $('.tab-nav .nav-btn');
                var $tabs = $('.tabs .tab');
                $tabBtns.on('click', function () {
                    var $this = $(this);
                    $this.addClass('current').siblings().removeClass('current');
                    var index = $tabBtns.index($this);
                    $($tabs.get(index)).addClass('current').siblings().removeClass('current');
                });
            },
            _initUserActions: function () {

                if (typeof Components === 'undefined') {
                    return;
                }

                $maskLayer.on('touchstart', function () {
                    return false;
                });


                $('.window-title .close').on('click', function () {
                    showMaskLayer(false);
                    showWindow($(this).parents('.window'), false);
                });


                function fillWindow($window) {
                    $window.find('.window-title .detail .title').html($('.goods-header .title').html());
                    $window.find('.window-title .price .value').html($('.goods-price .current').html());
                }


                Components.createQuantumControl($('.window.buy').find('.quantity'));
                Components.createQuantumControl($('.window.cart').find('.quantity'));

                var $windowBuy = $('.window.buy');
                var $windowCart = $('.window.cart');
                var $windowChuFang = $('.window.chufang');
                $('.footer .button.buy').on('click', function () {
                    showMaskLayer(true);
                    fillWindow($windowBuy);
                    var id = $('.detail .goods').attr('id').match(/\d+/)[0];
                    // $windowBuy.find('.added-product-id').val(id);
                    var $input = $('<input type="hidden" class="quantum-submit" name="product_id[' + id.match(/\d+/)[0] + ']" />');
                    $windowBuy.find('form').append($input);
                    showWindow($windowBuy, true);
                });

                $('.footer .button.chufang').on('click', function () {
                    showMaskLayer(true);
                    fillWindow($windowChuFang);
                    var id = $('.detail .goods').attr('id').match(/\d+/)[0];
                    // $windowBuy.find('.added-product-id').val(id);
                    var $input = $('<input type="hidden" class="quantum-submit" name="product_id[' + id.match(/\d+/)[0] + ']" />');
                    $windowChuFang.find('form').append($input);
                    showWindow($windowChuFang, true);
                });

                $('.footer .button.cart').on('click', function () {
                    showMaskLayer(true);
                    fillWindow($windowCart);
                    var id = $('.detail .goods').attr('id').match(/\d+/)[0];
                    $windowCart.find('.added-product-id').val(id);
                    showWindow($windowCart, true);
                });

                $windowBuy.find('.confirm button[type="submit"]').on('click', function () {
                    var quantum = $windowBuy.find('.quantum .quantity .txt').val();
                    $windowBuy.find('form .quantum-submit').val(quantum);
                });


                $('.specific .tag').on('click', function () {
                    $(this).addClass('active').siblings().removeClass('active');
                    $(".price .value").text(($(this).attr('price')));
                    if ($(this).attr('spec_id')) {
                        $("input[name=spec_id]").val($(this).attr('spec_id'));
                    }

                });
            },
            _initCartActions: function () {
                if (typeof Components === 'undefined') {
                    return;
                }

                var $edit = $('.shop-list .edit');
                $('.cart-item .quantity').each(function () {
                    Components.createQuantumControl($(this));
                });

                var $label = $('.footer .check-container .label');
                var $total = $('.total-price');
                var $btnPay = $('.btn.pay');
                var $btnDelete = $('.btn.delete');
                var $footerCheck = $('.footer .check');
                var originalValues = [];
                var index = 0;
                var $priceValue = $('.total-price-value');
                var $checks = $('.cart-item .check');
                $edit.on('click', function () {
                    var $this = $(this);
                    $this.toggleClass('active');
                    var active = $this.hasClass('active');
                    //var originalValues = [];
                    //var index = 0;

                    if (active) {
                        $this.text('完成');
                        $('.cart-item').each(function () {
                            var $this = $(this);
                            var value = $this.find('.num .value').text();
                            $this.find('.quantity .txt').val(value);
                            //originalValues[index++] = value;
                        });
                        $('.cart-item').find('.quantity').show();
                        $('.cart-item').find('.num .value').hide();

                        $('.cart-item .check').attr('class', '').addClass('check')
                        $btnPay.hide();
                        $btnDelete.show().addClass('disabled');
                        $total.css({
                            visibility: 'hidden'
                        });
                    } else {
                        $this.text('编辑');
                        $('.cart-item').find('.quantity').hide();
                        $('.cart-item').find('.num .value').show();
                        index = 0;
                        $('.cart-item').each(function () {
                            var $this = $(this);
                            $this.find('.check').removeClass('delete');
                            //var id = $this.attr('id').match(/\d+/)[0];
                            var id = $this.attr('id').substr(8);
                            var quantity = $this.find('.quantity .txt').val();
                            if (originalValues[index] === quantity) {
                                return;
                            }
                            $.post({
                                url: '/shop/cart/update',
                                data: {
                                    product_id: id,
                                    quantity: quantity
                                },
                                dataType: 'json'
                            }).done(function (data) {
                                //originalValues[index] = quantity;
                                //index++;
                            });
                            //originalValues[index] = quantity;
                            //index++;
                        });

                        $total.css({
                            visibility: 'visible'
                        });


                        $('.cart-item .quantity').each(function () {
                            var $this = $(this);
                            $this.siblings('.value').text($this.find('.txt').val());
                        });

                        $btnDelete.hide();
                        $btnPay.show().addClass('disabled');
                        $checks.removeClass('checked');
                        updateTotalPrice();
                    }

                    $label.addClass('disabled');
                    $footerCheck.removeClass('checked');
                });


                //var $checks = $('.cart-item .check');

                function updateTotalPrice() {
                    var total = 0;
                    $checks.each(function () {
                        var $this = $(this);
                        if ($this.hasClass('checked')) {
                            var price = parseFloat($this.parents('.cart-item').find('.price .value').text());
                            var count = parseFloat($this.parents('.cart-item').find('.num .value').text());

                            total += price * count;
                        }
                    });

                    $priceValue.text(total);
                    // $('.btn.pay').find('.count').html($checks.filter('.checked').length);
                    $btnPay.val('结算(' + $checks.filter('.checked').length + ')');
                }

                $btnPay.on('click', function () {
                    var $form = $('.cart .footer form');
                    $('.cart-list .cart-item').each(function () {
                        var $this = $(this);
                        if ($this.find('.check.checked').length) {
                            //var $item = $('<input type="hidden" name="product_id[' + $this.attr('id').match(/\d+/)[0] + ']" value="' + $this.find('.count .num .value').text() + '" />');
                            var $item = $('<input type="hidden" name="product_id[' + $this.attr('id').substr(8) + ']" value="' + $this.find('.count .num .value').text() + '" />');
                            $form.append($item);
                        }
                    });
                });

                updateTotalPrice();


                //var $checks = $('.cart-item .check');

                $checks.on('click', function () {
                    var isEdit = $edit.hasClass('active');
                    var $this = $(this);

                    if (!isEdit) {
                        $this.toggleClass('checked');
                    } else {
                        $this.toggleClass('delete');
                    }

                    if ($checks.filter('.checked').length || $checks.filter('.delete').length) {
                        $btns.removeClass('disabled');
                        $label.removeClass('disabled');
                    } else {
                        $btns.addClass('disabled');
                        $label.addClass('disabled');
                    }


                    updateTotalPrice();
                    $('.btn.pay').find('.count').html($checks.filter('.checked').length);
                });


                var $btns = $('.footer .btn');
                $('.footer .select-all .check').on('click', function () {
                    var $this = $(this);
                    var $label = $this.siblings('.label');

                    var isEdit = $edit.hasClass('active');

                    if (isEdit) {
                        $this.toggleClass('delete');
                    } else {
                        $this.toggleClass('checked');
                    }

                    var isCheck = $this.hasClass('checked') || $this.hasClass('delete');

                    if (isCheck) {
                        if (!isEdit) {
                            $checks.addClass('checked');
                        } else {
                            $checks.addClass('delete');
                        }
                        $btns.removeClass('disabled');
                        $label.removeClass('disabled');
                    } else {
                        if (!isEdit) {
                            $checks.removeClass('checked');
                        } else {
                            $checks.removeClass('delete');
                        }
                        $btns.addClass('disabled');
                        $label.addClass('disabled');
                    }


                    updateTotalPrice();
                });

                $('.btn.delete').on('click', function () {
                    var $items = $('.cart-item');
                    $items.each(function () {
                        var $this = $(this);
                        if ($this.find('.check.delete').length != 0) {
                            //var id = $this.attr('id').match(/\d+/)[0];
                            var id = $this.attr('id').substr(8);
                            var quantity = $this.find('.num .value').text();
                            console.log(quantity);
                            //$this.remove();
                            $.ajax({
                                url: '/shop/cart/delete',
                                data: {
                                    product_id: id,
                                    quantity: quantity
                                }
                            }).done(function (data) {
                                if (data.success) {
                                    $this.remove();

                                    if ($('.cart .cart-list .cart-item').length === 0) {
                                        window.location.reload();
                                    }
                                }
                            })
                        }
                    });
                })
            },
            _initAddressActions: function () {
                if (typeof Components === 'undefined') {
                    return;
                }
                Components.createCityPicker($('#province'), $('#city'), $('#district'));
                var $window = $('.window.address');
                $('.express').on('click', function () {
                    if ($(this).find('.address.on').length) {
                        window.location.href = '/shop/select-address';
                        return false;
                    }
                    showMaskLayer(true);
                    //showWindow($window, true);
                    window.location.href = '/shop/address/pay-create';
                })
            },
            _moveCartButton: function () {
                if (typeof $.fn.pep === 'undefined') {
                    return;
                }
                $('.global-cart').pep({
                    constrainTo: 'window',
                    shouldPreventDefault: false,
                    //allowDragEventPropagation: false
                    useCSSTranslation: false
                });
            },
            _handleCart: function () {
                var callBack = function () {
                    var $window = $(this).parents('.window');
                    //var productId = $window.data('product_id');
                    var productId = $window.find('.added-product-id').val();
                    var spec_id = $window.find('input[name=spec_id]').val();
                    if (spec_id) {
                        productId = productId.match(/\d+/)[0] + '-' + spec_id
                    } else {
                        productId = productId.match(/\d+/)[0];
                    }

                    var quantity = $window.find('.quantity .txt').val();
                    var $notify = $('.notify');
                    $.post({
                        url: '/shop/cart/add',
                        data: {
                            product_id: productId,
                            quantity: quantity
                        },
                        dataType: 'json'
                    }).done(function (data) {
                        if (data.success) {
                            //
                            $.post({
                                url: '/shop/cart/count',
                                dataType: 'json'
                            }).done(function (data) {
                                if (data.success) {
                                    $('.title-num').text(parseFloat(data.count));
                                }
                            })
                            showWindow($window, false);
                            showMaskLayer(true);
                            $notify.fadeIn();
                            setTimeout(function () {
                                $notify.fadeOut();
                                showMaskLayer(false);
                            }, 3000);
                        }
                    });
                }
                $('.window .confirm .btn.add-cart').on('click', callBack);
                $('.window.cart .confirm .next').on('click', callBack);
            },
            //_fillIndex: function () {
            //
            //    if (!$(document.body).hasClass('index')) {
            //        return;
            //    }
            //
            //    var $windowBuy = $('.window.buy');
            //
            //    function makeItem(data) {
            //        if (!data) {
            //            return null;
            //        }
            //
            //
            //        var html = '<a class="product" id="product-' + data.id + '"' + 'href="/shop/detail?id=' + data.id + '">';
            //        html += '<div class="product-pic">';
            //        html += '<img src="' + data.logo + '">';
            //        html += '</div>';
            //        html += '<div class="product-info">';
            //        html += '<p class="product-name">' + data.name + '</p>';
            //        html += '<p class="product-price">';
            //        html += '<span class="price">&yen;' + data.price + '</span>';
            //        html += '/';
            //        html += '<span class="other">' + data.beans + '迈豆</span>';
            //        html += '</p>';
            //        html += '</div>';
            //        //if (data.is_on_sale == 1) {
            //        //    html += '<span class="buy">购买</span>';
            //        //} else {
            //        //    html += '<span class="disabled-buy">不可购买</span>';
            //        //}
            //        html += '</a>';
            //        var $html = $(html);
            //
            //        //$html.find('.buy').on('click', function (event) {
            //        //    var $parent = $(this).parents('.product');
            //        //    $windowBuy.find('.preview img').attr('src', $parent.find('.product-pic img').attr('src'));
            //        //    $windowBuy.find('.detail .title').text($parent.find('.product-name').text());
            //        //    var price = $parent.find('.product-price .price').text();
            //        //    price = price.substring(1, price.length);
            //        //    $windowBuy.find('.price .value').text(price);
            //        //    var productId = $parent.attr('id');
            //        //    //$windowBuy.data('product_id', productId);
            //        //    $windowBuy.find('.added-product-id').val(productId.match(/\d+/)[0]);
            //        //    showMaskLayer(true);
            //        //    //fillWindow($windowBuy);
            //        //    showWindow($windowBuy, true);
            //        //
            //        //    event.preventDefault();
            //        //});
            //
            //        return $html;
            //
            //    }
            //
            //    var nextPageUrl = null;
            //    var currentPage = 0;
            //    var lastPage = 0
            //    var $productsContainer = $('.products-wrapper');
            //    $.ajax({
            //        url: '/shop/product-list',
            //    }).done(function (data) {
            //        nextPageUrl = data.next_page_url;
            //        currentPage = data.current_page;
            //        lastPage = data.last_page;
            //        //for(var i = 0; i < data.total; ++i) {
            //        //var $item = makeItem(data.data[i]);
            //        //$productsContainer.append($item);
            //        //}
            //    });
            //
            //    var lastScrollTop = 0;
            //    $(document).scroll(function () {
            //        var st = $(document).scrollTop();
            //        if ($(document).scrollTop() + $(window).height() > $(document).height() - $('.footer').height() && st > lastScrollTop) {
            //            if (currentPage + 1 > lastPage) {
            //                $('.loading .more').text('没有更多商品了');
            //                return;
            //            }
            //            $('.loading .more').text('正在加载...');
            //            $.ajax({
            //                url: nextPageUrl,
            //            }).done(function (data) {
            //                nextPageUrl = data.next_page_url;
            //                currentPage = data.current_page;
            //                for (var i = 0; i < data.total; ++i) {
            //                    var $item = makeItem(data.data[i]);
            //                    $productsContainer.append($item);
            //                }
            //                // 重新加载
            //            });
            //        }
            //        lastScrollTop = st;
            //    });
            //    //$('.loading .more').on('click', function() {
            //    //    var $this = $(this);
            //    //    if(currentPage + 1 > lastPage) {
            //    //        $this.text('没有更多项目')
            //    //        return;
            //    //    }
            //    //
            //    //    $this.text('正在加载...')
            //    //    $.ajax({
            //    //        url: nextPageUrl,
            //    //    }).done(function(data) {
            //    //        nextPageUrl = data.next_page_url;
            //    //        currentPage = data.current_page;
            //    //        for(var i = 0; i < data.data.length; ++i) {
            //    //            var $item = makeItem(data.data[i]);
            //    //            if(!$item) {
            //    //                $this.text('加载更多')
            //    //                return;
            //    //            }
            //    //            $productsContainer.append($item);
            //    //        }
            //    //        $this.text('加载更多')
            //    //    });
            //    //});
            //},
            _handleDetail: function () {
                //$('.detail .button.buy').on('click', function() {
                //var id = $('.detail .goods').attr('id').match(/\d+/)[0];
                //$('#added-product-id').val(id);
                //});
                $('.window .chufang .upload').on('click', function () {
                    $(this).siblings('input').trigger('click');
                });
                // $('.window .chufang .upload+input').on('change', function() {
                //     console.log($(this).val());
                // });
            },
            _handleAddress: function () {
                var $submitBtn = $('.address form .save .btn');
                $('.address .footer.create .button.save').on('click', function () {
                    var $form = $('.address form');
                    var name = $form.find('.name').val();
                    var phone = $form.find('.phone').val();
                    var province = $form.find('#province').val();
                    var city = $form.find('#city').val();
                    var district = $form.find('#district').val();
                    var address = $form.find('.detail-address').val();
                    var zip = $form.find('.zip-code').val();
                    if (!validateForm(name, phone, province, city, district, address, zip)) {
                        return false;
                    }
                    $submitBtn.click();
                });


                $('.address .footer .button.cancle').on('click', function () {
                    window.history.go(-1);
                });
                var $addressWindow = $('.window.address');
                $('.address .address-item .address-edit-container i').on('click', function () {
                    var $this = $(this);
                    var $parent = $this.parents('.address-item');
                    var name = $parent.find('.address-item-customer-name').text();
                    var tel = $parent.find('.address-item-customer-tel').text();
                    // var address = $parent.find('.address-item-address').text();
                    var province = $parent.find('.address-item-address .province').text();
                    var city = $parent.find('.address-item-address .city').text();
                    var district = $parent.find('.address-item-address .district').text();
                    var address = $parent.find('.address-item-address .detail-address-info').text();
                    var id = $parent.data('address_id');
                    $addressWindow.find('input[name="name"]').val(name.trim());
                    $addressWindow.find('input[name="phone"]').val(tel.trim());
                    // $addressWindow.find('input[name="address"]').val(address.trim());
                    $addressWindow.find('#province').find('option[value="' + province + '"]').prop('selected', true).end().trigger('change');
                    $addressWindow.find('#city').find('option[value="' + city + '"]').prop('selected', true);
                    // $addressWindow.find('#city').val(city.trim());
                    if (district && district.length) {
                        $addressWindow.find('#city').trigger('change');
                        $addressWindow.find('#district').find('option[value="' + district + '"]').prop('selected', true);
                    } else {
                        $addressWindow.find('#district').parent().hide();
                    }
                    $addressWindow.find('input[name="address"]').val(address.trim());
                    $addressWindow.data('address_id', id);
                    showMaskLayer(true);
                    showWindow($addressWindow, true);
                });
                var $footerForm = $('.address .footer form');
                $footerForm.find('.selected_address').val($($('.address .address-item').get(0)).data('address_id'));
                $('.address .address-item .check').on('click', function () {
                    var $this = $(this);
                    var $parent = $this.parents('.address-item');
                    var id = $parent.data('address_id');
                    $footerForm.find('.selected_address').val(id);
                    $this.addClass('checked');
                    $parent.siblings('.address-item').find('.check').removeClass('checked');
                });

                $('.address .footer form .button.save').on('click', function () {
                    var id = $footerForm.find('.selected_address').val();
                    if (!id || !id.length) {
                        showNotify('请添加地址！', 3000);
                        return false;
                    }
                });

                var id = $('.pay .address-panel .address-detail').data('address_id');
                var $payForm = $('.pay form');
                $payForm.find('.selected_address').val(id);

                $payForm.find('.confirm .next').on('click', function () {
                    //var id = $payForm.find('.selected_address').val();
                    //var $textarea = $('.pay .goods-list .order-msg textarea');
                    //$payForm.find('.user_message').val($textarea.val());
                    //if (!id || !id.length) {
                    //    showNotify('地址不能为空！', 3000);
                    //    return false;
                    //}
                })
            },
            _handleAddressTasks: function () {
                var $addressWindow = $('.pay .window.address');
                $addressWindow.find('.save').on('click', function (event) {
                    var name = $addressWindow.find('.name').val();
                    var phone = $addressWindow.find('.phone').val();
                    var province = $addressWindow.find('#province').val();
                    var city = $addressWindow.find('#city').val();
                    var district = $addressWindow.find('#district').val();
                    var address = $addressWindow.find('.detail-address').val();
                    var zip = $addressWindow.find('.zip-code').val();
                    if (!validateForm(name, phone, province, city, district, address, zip)) {
                        return false;
                    }

                    $.ajax({
                        url: '/shop/address/store',
                        method: 'GET',
                        data: {
                            name: name,
                            phone: phone,
                            province: province,
                            city: city,
                            district: district,
                            address: address,
                            zip: zip
                        }
                    }).done(function (data) {
                        if (!data.success) {
                            showNotify('添加地址失败', 3000);
                            return false;
                        }

                        var name = data.data.address.name;
                        var tel = data.data.address.phone;
                        var province = data.data.address.province;
                        var city = data.data.address.city;
                        var district = data.data.address.district;
                        var detail = data.data.address.address;
                        var address = data.data.address.province + data.data.address.city + data.data.address.district + data.data.address.address;
                        var id = data.data.address.id;

                        var $addressItem = $('.pay .address.item');
                        var $addressDetail = $addressItem.find('.address-detail');
                        $addressDetail.find('.name').text('收货人：' + name);
                        $addressDetail.find('.tel').text(tel);
                        $addressDetail.find('.address-detail-info p').text('收货地址：' + address);
                        //$addressDetail.data('address_id', id);
                        $addressDetail.attr('data-address_id', id);
                        $('.pay .goods-list form .selected_address').val(id);
                        $addressItem.addClass('on').siblings().removeClass('on');

                        var $input = '<input type="hidden" name="address_phone" value="' + tel + '"/>' +
                            '<input type="hidden" name="address_name" value="' + name + '"/>' +
                            '<input type="hidden" name="address_province" value="' + province + '"/>' +
                            '<input type="hidden" name="address_city" value="' + city + '"/>' +
                            '<input type="hidden" name="address_district" value="' + district + '"/>' +
                            '<input type="hidden" name="address_detail" value="' + detail + '"/>';
                        $('#pay-form').append($input);

                        showWindow($addressWindow, false);
                        showMaskLayer(false);

                        showNotify('添加地址成功', 3000);

                    });
                    event.stopPropagation();

                });


                var $aWindow = $('.address .window.address');
                $aWindow.find('.save').on('click', function (event) {
                    var name = $aWindow.find('.name').val();
                    var phone = $aWindow.find('.phone').val();
                    var province = $aWindow.find('#province').val();
                    var city = $aWindow.find('#city').val();
                    var district = $aWindow.find('#district').val();
                    var address = $aWindow.find('.detail-address').val();
                    var zip = $aWindow.find('.zip-code').val();

                    var id = $aWindow.data('address_id');
                    if (!validateForm(name, phone, province, city, district, address, zip)) {
                        return false;
                    }

                    $.ajax({
                        url: '/shop/address/update',
                        method: 'GET',
                        data: {
                            id: id,
                            name: name,
                            phone: phone,
                            province: province,
                            city: city,
                            district: district,
                            address: address,
                            zip: zip
                        }
                    }).done(function (data) {
                        if (!data.success) {
                            showNotify('更新地址失败', 3000);
                            return false;
                        }

                        var $address = $('.address .address-item[data-address_id="' + id + '"]');

                        var name = data.data.address.name;
                        var tel = data.data.address.phone;
                        var address = data.data.address.province + data.data.address.city + data.data.address.district + data.data.address.address;
                        //var id = data.data.address.id;

                        $address.find('.address-item-customer-name').text(name);
                        $address.find('.address-item-customer-tel').text(tel);
                        $address.find('.address-item-address').text(address);


                        showNotify('更新地址成功', 3000);
                        showWindow($aWindow, false);

                    });
                    event.preventDefault();
                    event.stopPropagation();

                });


                $aWindow.find('.delete').on('click', function (event) {
                    var id = $aWindow.data('address_id');
                    $.ajax({
                        url: '/shop/address/delete',
                        method: 'GET',
                        data: {
                            id: id
                        }
                    }).done(function (data) {
                        if (!data.success) {
                            showNotify('删除地址失败', 3000);
                        }
                        showNotify('删除地址成功', 3000);
                        showWindow($aWindow, false);
                        var $address = $('.address .address-item[data-address_id="' + id + '"]');
                        $address.remove();
                    });
                })


            },
            _handlePayTasks: function () {
                var total = 0;
                $('.pay .goods-list .cart-item').each(function () {
                    var $this = $(this);
                    var price = parseFloat($this.find('.count .price .value').text());
                    var count = parseFloat($this.find('.count .num .value').text());
                    total += price * count;
                });
                $('.block-item.total .price .value').text(total);
                var delivery = parseFloat($('.block-item.delivery-fee .value').text());
                var beans = 0;
                var rmb = 0;
                var msg = '';
                if ($('.block-item.coupon').length) {
                    beans = parseFloat($('.block-item.coupon .num.beans').text());
                    rmb = parseFloat($('.block-item.coupon .num.rmb').text());
                    msg = '&yen;' + total + ' + &yen;' + delivery + ' 运费 ' + '- ' + rmb + '元迈豆抵现';
                } else {
                    msg = '&yen;' + total + ' + &yen;' + delivery + ' 运费';
                }

                rmb.toFixed(2);
                delivery.toFixed(2);
                total.toFixed(2);
                var total = total + delivery - rmb;
                total.toFixed(2);
                $('.block-item.pay-info p').html(msg);
                $('.block-item.pay-info .total').html('&yen;' + total);
            },
            _handleOrder: function () {
                // var total = 0;
                // $('.order .order-item').each(function() {
                //     var $this = $(this);
                //     $this.find('.goods .cart-item').each(function() {
                //         var $this = $(this);
                //         var price = parseFloat($this.find('.count .price .value').text());
                //         var count = parseFloat($this.find('.count .num .value').text());
                //         total += price * count;
                //     });
                //     $this.find('.block-item.total .price .value').text(total);
                //     total = 0;
                // });

                $('.order .btn-group .btn.cancel').on('click', function () {
                    var $orderItem = $(this).parents('.order-item');
                    // var bool
                    // var $carts = $orderItem.find('.cart-item');
                    // var len = $carts.length;
                    var id = $orderItem.data('order_id');
                    var order_id = $orderItem.find('.header .shop').text().match(/\d+/)[0];
                    $.ajax({
                        url: '/shop/order/delete',
                        data: {
                            order_id: id
                        }
                    }).done(function (data) {
                        if (data.success) {
                            $orderItem.remove();
                            showNotify('取消订单<br>' + order_id + ' <br>成功!', 3000);

                            if ($('.order .order-item').length === 0) {
                                window.location.reload();
                            }
                        }
                    });
                    // $carts.each(function() {
                    //     var $this = $(this);
                    //     var id = $this.data('order_id');
                    //     $.ajax({
                    //         url: '/shop/cart/delete',
                    //         data: {
                    //              order_id: id,
                    //         }
                    //     }).done(function(data) {
                    //         if(data.success) {
                    //             ++index;
                    //             if (index == len && !fail) {
                    //                 $orderItem.remove();
                    //                 showNotify('取消订单 ' + order_id + ' 成功!', 3000);
                    //             }
                    //         } else {
                    //             fail = true;
                    //         }
                    //     });
                    // });
                });
            },
            _initOrderDetailActions: function () {
                $('.orderDetail').on('click', function () {
                    var $orderItem = $(this).parents('.order-item');
                    var id = $orderItem.data('order_id');
                    window.location.href = '/shop/order/detail?order_id=' + id;
                    return false;
                })
            },
            _initWechatPayActions: function () {

            }
        };

        return Main.init();
    }

    $(document).ready(function () {
        $(Application);
    });


})(jQuery);
