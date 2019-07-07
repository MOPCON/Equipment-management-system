<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <form id="accessform">
                <div>
                    <label>密碼</label><br />
                    <input id="access_screct" type="password" name="password" value="e4L2JwkkAtjNGeoq5c7Y">
                </div>
                <input id="access_send" type='button' value="提交"/>
            </form>
    
            <form id="sendform">
            </form>
        </div>
        <script>
            function convert(key, value, target) {
                const reg = new RegExp('_path');
                if(value === null){
                    value = '';
                }
                let element;
                if (key.match(reg) !== null) {
                    element = "<div><label>" + key + "</label><br />";
                    if(value !== ''){
                        element += "<img src='" + value + "' height='100' ><br />";
                    }
                    element += "<input class='send' type='file' name='" + key + "' value='' /></div>";
                } else {
                    element = "<div><label>" + key + "</label><br /><input class='send' name='" + key + "' value='" + value + "' /></div>"
                }
                target.append(element);
            }

            function sendform() {
                let data = $('.send');
                let send_data = new FormData();
                const reg = new RegExp('_path');
                data.each((i, d,) => {
                    if(d.value !== undefined || d.value !== null){
                        if (d.name.match(reg) !== null) {
                            if(d.files.length > 0){
                                send_data.set(d.name, d.files[0]);
                            }
                        } else {
                            send_data.set(d.name, d.value);
                        }
                    }
                })
                send_data.set('_method', 'PUT');
                axios.post('/sponsor/{{$main['access_key']}}',send_data)
                    .then((response) => {
                        alert(response.data.message);
                        console.log(response.data);
                    })
                    .catch((err) => {
                        alert(err.response.data.message);
                        console.log(err.response.data.message);
                    })
            }

            $('#access_send').off().on('click', () => {
                let password = document.getElementById('access_screct').value;
                console.log(password);
                axios.post('/sponsor/{{$main['access_key']}}', {
                    'password': password,
                }).then((response) => {
                    let data = response.data.data;
                    let main = data.main;
                    let recipe = data.recipe;
                    let advence = data.advence;
                    let target = $('#sendform');

                    Object.keys(main).forEach((index) => {
                        const reg = new RegExp('_at|_text|_key');
                        if(index.match(reg) === null){
                            convert(index, main[index], target);
                        }
                    })

                    Object.keys(recipe).forEach((index) => {
                        convert(index, recipe[index], target);
                    })
                    Object.keys(advence).forEach((index) => {
                        convert(index, advence[index], target);
                    })

                    passwore_element = "<input type='hidden' class='send' name='password' value='" + password + "' />";
                    target.append(passwore_element);
                    submit_element = "<input id='sendbtn' type='button' name='password' value='提交' />";
                    target.append(submit_element);
                    $('#sendbtn').on('click', sendform);
                    $('#accessform').remove();
                })
            })
        </script>
    </body>
</html>