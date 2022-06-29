<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/static/css/base.css">
    <link rel="stylesheet" href="/static/css/bootanimation.css">
    <link rel="icon" type="image/x-icon" href="/static/assets/favicon/favicon128.ico">
    <script src="/static/js/jquery-3.6.0.js"></script>
    <title>bootanimation</title>
</head>
<body>
<div class="wrap">
    <div class="input-url-bl">
        <div class="wrapper">
            <div id="background"></div>
            
            <div class="main">
                
            </div>
        </div>
    </div>
    
    <header>
        <div class="section-wrapper">
            <div class="logo">
                <img src="/static/assets/favicon/favicon256.ico" alt="bootanimation">
                
                <span>bootanimation</span>
            </div>
        </div>
    </header>
    
    <section class="content">
        <div class="section-wrapper">
            <div class="upload-bl">
                <div class="file-upload">
                    <input id="file" name="file" type="file">
                    
                    <label for="file">
                        <div class="img-wrapper">
                            <img src="/static/assets/icons/upload.ico" alt="bootanimation">
                        </div>
                        
                        <p class="label-title">Drag and drop or paste GIF here to upload</p>
                        <p class="label-sub">You can also <a>browse from your computer</a> or <a id="fromUrlBtn">add image URLs.</a></p>
                    </label>
                </div>
            </div>
            
            <div class="settings-bl">
                <input id="file" name="file" type="file">
                
                <label class="preview" for="file">
                    <div class="preview-inner">
                        <img id="preview-src" src="#" alt="bootanimation">
                    </div>
                </label>
                
                <input id="submit" type="button" value="START">
            </div>
        </div>
    </section>
    
    <footer>
        <div class="section-wrapper">
            
        </div>
    </footer>
</div>

<!-- downloading response solution -->
<iframe id="dl" style="display:none;"></iframe>

<script src="/static/js/requestBootanimation.js"></script>
<script src="/static/js/fromURL.js"></script>

</body>
</html>
