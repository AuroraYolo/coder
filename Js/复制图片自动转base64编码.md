```html
<meta charset="UTF-8">
<title>粘贴上传图片</title>
<style type="text/css">
/*.tips{*/
/*font-size:14px;*/
/*color:#7a7a7a;*/
/*}*/
/*#preview{*/
/*width:400px;*/
/*height:200px;*/
/*}*/
/*#preview img{*/
/*max-width:100%;*/
/*max-height:100%;*/
/*}*/
/*.preview:after{*/
/*width:100%;*/
/*content:'预览';*/
/*display:block;*/
/*text-align:center;*/
/*font-size:45px;*/
/*line-height:200px;*/
/*color:#dddddd;*/
/*border:3px dashed #eeeeee;*/
/*}*/
</style>
<p class="tips">提示: 从任意网页右击复制图片或者直接用QQ等软件截图，然后点击激活该页面，粘贴</p>
<textarea style="width:2500px;height:1800px;" id="preview" class="preview" onpaste="return false"></textarea>

<script type="text/javascript">
  document.addEventListener('paste', base64);

functionbase64(e){
return newPromise(function(resolve, reject){
constitems = ((e.clipboardData || window.clipboardData).items) || [];
letfile =null;
if(items && items.length){
for(leti = 0; i < items.length; i++){
if(items[i].type.indexOf('image') !== -1){
            file = items[i].getAsFile();
break;
          }
        }
      }
if(!file){
        alert('粘贴内容非图片！');
return;
      }
letcontent = document.getElementById('preview');
letcursurPosition = -1;
if(content.value && content.value.length > 0){
if(content.selectionStart){//非IE浏览器
          cursurPosition = content.selectionStart;
        }else{//IE
letrange = document.selection.createRange();
          range.moveStart("character", -content.value.length);
          cursurPosition = range.text.length;
        }
      }
      cursurPosition = cursurPosition == 0 ? 1 : cursurPosition;
constreader =newFileReader();
      reader.onload =function(e){
letstartValue = content.value.substring(0, cursurPosition);
letendValue = content.value.substring(cursurPosition);
        preview.value = startValue + e.target.result + endValue;
        resolve(e)
      }
      reader.onerror =function(error){
        reject(error)
      };
      reader.readAsDataURL(file);
    });
  };
</script>
```


