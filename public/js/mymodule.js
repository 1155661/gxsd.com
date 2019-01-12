//我封装的模块
let myModule = function () {
   return{
       //异步请求数据，并进行分页处理
        newLayPage(URL,elem,id){
           let str = elem,
                newUrl = URL,
                newElem = elem,
                newId = id;
            axios.get(URL).then(function (value) {

                if(value.status === 200){
                    let data = value.data;
                    layui.use(['laypage','element'],function () {
                        let laypage = layui.laypage,
                            $ = layui.$;

                        laypage.render({
                            elem:id,
                            count:data.length,
                            limit:8,
                            layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                            jump:function (obj) {
                                str.list = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                            }
                        });
                    });
                }else if (value.status === 500) {
                    // console.log(value.status);
                    this.newLayPage(newUrl,newElem,newId)
                }


            }).catch(function (error) {
               // this.newLayPage();
                console.log(error);
            })
       },
       //弹窗模块
       newLayer(i,content){
           layui.use(['element','layer'],function () {
               if(i === 1){
                   layer.alert(content,{
                       icon:1,
                       skin:'layui-layer-molv',     //弹窗皮肤
                       btn1(){
                           layer.closeAll();
                       }
                   });
               }else {
                   layer.alert(content,{icon:5,skin:'layui-layer-molv'});
               }
           })
       },
       //表单弹窗模块
       newLayerOpen(i,elem1,width){
           //i 用于判断弹窗的用途，提高重用性，1是添加，0是修改
           let title = i ? '添加' : '修改';

           layui.use(['element','layer','form'],function () {
               layer.open({
                   type:1,
                   title: title,
                   skin:'layui-layer-molv',
                   shadeClose:true,
                   content:elem1,
                   area:['500px',width],
               })
           })
       },
       //导出excel 模块
       JSONToExcelConvertor(JSONData, FileName,title,filter){
           if(!JSONData)
               return;
           //转化json为object
           var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

           var excel = "<table>";

           //设置表头
           var row = "<tr>";

           if(title)
           {
               //使用标题项
               for (var i in title) {
                   row += "<th align='center'>" + title[i] + '</th>';
               }

           }
           else{
               //不使用标题项
               for (var i in arrData[0]) {
                   row += "<th align='center'>" + i + '</th>';
               }
           }

           excel += row + "</tr>";

           //设置数据
           for (var i = 0; i < arrData.length; i++) {
               var row = "<tr>";

               for (var index in arrData[i]) {
                   //判断是否有过滤行
                   if(filter)
                   {
                       if(filter.indexOf(index)==-1)
                       {
                           var value = arrData[i][index] == null ? "" : arrData[i][index];
                           row += '<td>' + value + '</td>';
                       }
                   }
                   else
                   {
                       var value = arrData[i][index] == null ? "" : arrData[i][index];
                       row += "<td align='center'>" + value + "</td>";
                   }
               }

               excel += row + "</tr>";
           }

           excel += "</table>";

           var excelFile = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";
           excelFile += '<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
           excelFile += '<meta http-equiv="content-type" content="application/vnd.ms-excel';
           excelFile += '; charset=UTF-8">';
           excelFile += "<head>";
           excelFile += "<!--[if gte mso 9]>";
           excelFile += "<xml>";
           excelFile += "<x:ExcelWorkbook>";
           excelFile += "<x:ExcelWorksheets>";
           excelFile += "<x:ExcelWorksheet>";
           excelFile += "<x:Name>";
           excelFile += "{worksheet}";
           excelFile += "</x:Name>";
           excelFile += "<x:WorksheetOptions>";
           excelFile += "<x:DisplayGridlines/>";
           excelFile += "</x:WorksheetOptions>";
           excelFile += "</x:ExcelWorksheet>";
           excelFile += "</x:ExcelWorksheets>";
           excelFile += "</x:ExcelWorkbook>";
           excelFile += "</xml>";
           excelFile += "<![endif]-->";
           excelFile += "</head>";
           excelFile += "<body>";
           excelFile += excel;
           excelFile += "</body>";
           excelFile += "</html>";


           var uri = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(excelFile);

           var link = document.createElement("a");
           link.href = uri;

           link.style = "visibility:hidden";
           link.download = FileName + ".xls";

           document.body.appendChild(link);
           link.click();
           document.body.removeChild(link);
       },
       //封装layui导入功能组件
       newImpExcel(URL,id){
           layui.use('upload',function () {
               let upload = layui.upload;

               upload.render({
                   elem:id,
                   accept:'file',
                   method:'POST',
                   type:'file',
                   url:URL,
                   data:{'_token':'{{csrf_token()}}'},
                   before:function (obj) {
                       layer.load();
                   },
                   done:function (res,index,upload) {
                       if(res === 1){
                           myModules.newLayer(1,'导入成功');
                       }
                       // return res;
                   }
               })

           })
       }
   }
};
export {myModule}