layui.use(['element','layer'],function () {
    var element = layui.element,
        layer = layui.layer,
        $ = layui.jquery;

    //程序入口
    function main() {

        //左侧导航栏
        $(document).on('click','.site-demo-active',function () {
            var dataid = $(this),
                url = dataid.attr('data-url'),
                id = dataid.attr('data-id'),
                title = dataid.attr('data-title');

            //限制打开相同选项卡的行为
            var tabSame = function () {
                var isData = false;

                //遍历带有lay-id属性的元素
                $.each($('.layui-tab-title li[lay-id]'),function () {

                    //如果导航栏的选项卡的id与新生成的选项卡id相同，isData则等于true
                    if(id == $(this).attr('lay-id')){
                        isData = true;
                    }
                });

                //如果isData等于false，则表示没有相同的选项卡
                if(isData == false){
                    tabAdd(url,id,title);
                }


            };
            //如果没有lay-id属性的元素，则添加新的tab，否则，走tabSame方法
            $('.layui-tab-title li[lay-id]').length <= 0 ? tabAdd(url,id,title) : tabSame();
            //跳转到已打开的选项卡
            element.tabChange('demo',id);
        });
        // element.init();
        //首页默认打开
        $('.site-demo-active').eq(0).click();
        // $('.site-demo-active').parents('dl');
        // console.log($('.site-demo-active').eq(0).parents('dl').prev().click());
        //任务管理
        $(document).on('click','.site-demo-username',function () {
            var dataid = $(this),
                url = dataid.attr('data-url'),
                id = dataid.attr('data-id'),
                title = dataid.attr('data-title');

            //限制打开相同选项卡的行为
            var tabSame = function () {
                var isData = false;

                //遍历带有lay-id属性的元素
                $.each($('.layui-tab-title li[lay-id]'),function () {

                    //如果导航栏的选项卡的id与新生成的选项卡id相同，isData则等于true
                    if(id == $(this).attr('lay-id')){
                        isData = true;
                    }
                });

                //如果isData等于false，则表示没有相同的选项卡
                if(isData == false){
                    tabAdd(url,id,title);
                }
            };
            //如果没有lay-id属性的元素，则添加新的tab，否则，走tabSame方法
            $('.layui-tab-title li[lay-id]').length <= 0 ? tabAdd(url,id,title) : tabSame();

            //跳转到已打开的选项卡
            element.tabChange('demo',id);
        })

    }
    main();

    function tabAdd(url, id, name) {
        element.tabAdd('demo',{
            title:name,
            content:'<iframe frameborder="0" scrolling="no" src="'+url+'" style="width:100%;height: 100%;"></iframe>',
            id:id
        })
    }

    // $('.search form input').focus(function () {
    //
    // })

});
