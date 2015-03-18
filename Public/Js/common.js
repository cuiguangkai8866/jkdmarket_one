/**
 * Created by Cangzhou.Wu on 15-2-10.
 */
$(function () {
    var sku = [];

    function descartes(list) {
        //parent上一级索引;count指针计数
        var point = {};

        var result = [];
        var pIndex = null;
        var tempCount = 0;
        var temp = [];

        //根据参数列生成指针对象
        for (var index in list) {
            if (typeof list[index] == 'object') {
                point[index] = {'parent': pIndex, 'count': 0}
                pIndex = index;
            }
        }

        //单维度数据结构直接返回
        if (pIndex == null) {
            return list;
        }

        //动态生成笛卡尔积
        while (true) {
            for (var index in list) {
                tempCount = point[index]['count'];
                temp.push(list[index][tempCount]);
            }

            //压入结果数组
            result.push(temp);
            temp = [];

            //检查指针最大值问题
            while (true) {
                if (point[index]['count'] + 1 >= list[index].length) {
                    point[index]['count'] = 0;
                    pIndex = point[index]['parent'];
                    if (pIndex == null) {
                        return result;
                    }

                    //赋值parent进行再次检查
                    index = pIndex;
                }
                else {
                    point[index]['count']++;
                    break;
                }
            }
        }
    }

    $('#product-table').on('click', '.sale-prop input[type=checkbox]', function (e) {
        $props = new Array();
        $('#sku').find('.sku-tr').each(function () {
            $props.push($(this).data('key'));
        });
        sku = [];
        skuText = [];
        $(':checkbox').each(function () {
            var value = $(this).val();
            var text = $(this).parent().text();
            var parent = $(this).data('product-prop-id');
            var tmpArry = [value];
            var textArry = [text];
            if ($(this).prop('checked')) {
                if (sku[parent] instanceof Array) {
                    sku[parent] = sku[parent].concat(tmpArry);
                    skuText[parent] = skuText[parent].concat(textArry);
                } else {
                    if (parent) {
                        sku[parent] = tmpArry;
                        skuText[parent] = textArry;
                    }
                }
            }
        });
        if (sku) {
            var result = descartes(sku);
            var resultText = descartes(skuText);
            var htm = '<tr><th>属性名称</th><th>库存</th><th>销售价格</th><th>市场价格</th><th>图片</th><th>状态</th><th>操作</th></tr>';
            for (i = 0; i < result.length; i++) {
                if ($.inArray(result[i].join(','), $props) != -1) {
                    $('#sku').find('.sku-tr').each(function () {
                        if ($(this).data('key') == result[i]) {
                            tmp = "<tr class='sku-tr'  data-key='" + result[i] + "'>" +
                            $(this).html() +
                            "</tr>";
                        }
                    });
                } else {
                    var imgHtml = '<div class="droparea spot" id="sku_pic_' + result[i] + '"' +
                        ' style="background-image: url();background-size: 80px 40px;cursor: pointer;width: 80px;  min-height: 40px;"><div class= "sku-image-add"' +
                        ' data-key="'+ result[i]+'"></div>' +
                        '<input type="hidden" name="Sku['+result[i]+'][pic]" ' +
                        'id="sku_pic_'+result[i]+'" /></div> ';
                    tmp = "<tr class='sku-tr'  data-key='" + result[i] + "'>" +
                    "<td scope='row'>" + resultText[i] + "</td>" +
                    "<td><input class='input' type='text' name='Sku[" + result[i] + "][stock]' value=''></td>" +
                    "<td><input class='input' type='text' name='Sku[" + result[i] + "][price]'></td>" +
                    "<td><input class='input' type='text' name='Sku[" + result[i] + "][market_price]'></td>" +
                    "<td>"+imgHtml+"</td>" +
                    "<td><select name='Sku[" + result[i] + "][status]'>" +
                    "<option value='0'>正常</option>" +
                    "<option value='1'>下架</option>" +
                    "<option value='2'>已售罄</option>" +
                    "</select></td>" +
                    "<td><div class='btn delete-btn'>删除</div></td>" +
                    "</tr>";
                }
                htm += tmp;
            }
            $("#sku").html(htm);

        }
    })


});