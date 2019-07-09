<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <form method="POST" action="/speaker/{{$speaker['access_key']}}" enctype="multipart/form-data">
            <div><label>密碼</label><br /><input type="password" name="password" value=""></div>
        @php
            foreach($speaker as $key => $value){
                if(!(preg_match('/(_at|_text|_key)/', $key) === 1 || is_array($value))){
                    printf("<div><label>%s</label><br /><input name='%s' value='%s' /></div>", $key, $key, $value);
                }
            }
        @endphp
        <input type='submit' />
        </form>
    </body>
</html>