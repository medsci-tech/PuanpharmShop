<OBJECT ID='x' name='x' CLASSID='CLSID:53C732B2-2BEA-4BCD-9C69-9EA44B828C7F' align=center hspace=0 vspace=0></OBJECT>

<hr />
<input type='button' value='显示Msg属性的值' onclick='ShowMsg()'/>
<input type='button' value='本地打印' onclick='localPrt()'/>
<input type='button' value='详情单补打(原单号)' onclick='rePrintOldNo()'/>
<input type='button' value='详情单补打(新单号)' onclick='rePrintNewNo()'/>
<input type='button' value='打印详情单' onclick='PrintBill()'/>
<input type='button' value='打印详情单(传重)' onclick='PrintBillWeight()'/>
<input type='button' value='打印测试' onclick='TestShowMsg()'/>
<input type='button' value='查询可用单号数' onclick='GetRemaindBillNO()'/>
<input type='button' value='批量打印' onclick='PrtBillBatch()'/>
<input type='button' value='验证' onclick='checkid()'/>
<script type='text/JavaScript'>
    var x = document.getElementById("x");
    var ShowMsg = function(){
        alert(x.PrtMsg);
    }

    //本地打印
    var localPrt = function(){
        //x.prtData.billno = '123456';
        alert(x.localPrt('head|4|2|5142577941500|2|2013-10-21 14:32|吴国雨|联系方式:0594-7659295||362009|乐麦海滨仓库|康亚飞|15103961193||742300|甘肃省陇南市徽县城关小学|甘肃省|陇南市|徽县|1040||||GR1310513,白色/乔丹红-41×1 合计：1|DD2013101700007|DD2013101700007||联系方式:0594-7659295|分销|end'));

//'head|4|2|5142577941500|2|2013-10-21 14:32|吴国雨|联系方式:0594-7659295||362009|乐麦海滨仓库|康亚飞|15103961193||742300|甘肃省陇南市徽县城关小学|甘肃省|陇南市|徽县|1040||||GR1310513,白色/乔丹红-41×1 合计：1|DD2013101700007|DD2013101700007||联系方式:0594-7659295|分销|end'));
//'head|4|2|5129667685500|2|2013-08-06 16:44:38|邮乐网|18258575464||214213|江苏省宜兴市经济开发区凯旋路18号(坤坤公司)|马锦涛|18258575464|18258575464|312000|浙江 绍兴市 越城区 敦煌新村14栋406室(312000)|浙江省|绍兴市|越城区|0.1360|0|0||物品|11383265202302|||经济快递|留白2|end'));
    }

    //补打获取新单号
    var rePrintNewNo = function(){
        alert(x.RePrtHotBillNewNO('A1234567890Z','SO121212001'));
    }
    //传入重量打印
    var PrintBillWeight = function(){
        alert(x.PrtHotBillWithInWeight('A1234567890Z','SO121212001','0.235'));
    }
    //补打使用原单号
    var rePrintOldNo = function(){
        alert(x.RePrtHotBill('A1234567890Z#%SO121212001'));
    }
    //批量打印
    var PrtBillBatch = function(){
        alert(x.PrtHotBillBatching('A1234567890Z#%SO121212001'));
//#%P3758017#%1234#%EY318313459CN#%P5256573#%P4758018#%P4758019#%P4758020#%EH0990
    }
    //打印详情单
    var PrintBill = function(){
        alert(x.PrtHotBillAndGetBillNo('A1234567890Z#%SO121212001'));
    }
    //打印测试
    var TestShowMsg = function(){
        alert(x.Test_PrtHotBillAndGetBillNo('A1234567890Z#%SO121212001'));
    }
    //查询可用单号余量
    var GetRemaindBillNO = function(){
        alert(x.CountNotUsedBillNo('A1234567890Z#%01'));
    }
    //账号验证
    // var checkid = function(){
    // alert(x.CheckID('A1234567890Z#%e10adc3949ba59abbe56e057f20f883e'));
    // 35020306770001
    //}
    var checkid = function(){
        alert(x.CheckID('42010670114000#%595600830807d207332c36fcd7a5c3e5'));

    }
</script>


<div id="info"></div>

<script type="text/javascript">

    var _info="";

    for(var p in x){
        _info += p + "：" + x[p] + "<br/>";
    }

    document.getElementById("info").innerHTML = _info;

</script>
</script>