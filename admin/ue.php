<script id="container" name="content" type="text/plain">这里输入内容</script>
<script src="ue/ueditor.config.js"></script>
<script src="ue/ueditor.all.js"></script>
<script>
    var cfg = {
        imagePopup: true,
        emotionLocalization: true,
        elementPathEnabled: false,
        wordCount: true,
        maximumWords: 10000,
        initialFrameWidth: '100%',
        initialFrameHeight: 500,
        toolbars: [[
            'undo',
            '|', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript',
            '|', 'removeformat', 'formatmatch', 'autotypeset',
            '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc',
            '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight',
            '|', 'fontfamily', 'fontsize',
            '|', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify',
            '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter',
            '|', 'simpleupload', 'insertimage', 'emotion'
        ]]
    }
    var ue = UE.getEditor('container', cfg);
</script>