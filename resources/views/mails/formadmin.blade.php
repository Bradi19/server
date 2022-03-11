<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доброго дня, {{ $demo->name }}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">

</head>

<body style="background:#f6f6f6;font-family: 'Montserrat', sans-serif;">

    <div style="max-width:600px;width:100%;margin:0 auto;padding:30px 0;">
        <div style="background:#fff;padding:0 0 20px 0;box-shadow:0 0 12px rgba(0,0,0,.15);">
            <div style="text-align:center;padding:40px 0;background:#9b0d28;">
                <p style="color:#fff;font-size:24px;margin:0;padding:0;text-transform:uppercase;font-weight:500;">
                    Новий замовник. </p>
            </div>
            <div style="padding:30px 20px;">
                <div style="background:#f6f6f6;padding:40px 20px;">
                    <h3 style="font-size:32px;color:#212121;font-weight:600;margin:0;">Ми звяжемось з вами в ближній
                        час!</h3>
                    <p style="font-size:14px;color:#242424;font-weight:400;">
                        Імя - <span> {{ $demo->name }} </span>
                    </p>
                    <p style="font-size:14px;color:#242424;font-weight:400;">
                        Посилання - <span>{{ $demo->link }}</span>
                    </p>
                    <p style="font-size:14px;color:#242424;font-weight:400;">
                        Назва проекту - <span>{{ $demo->name_project }}</span>
                    </p>
                    <p style="font-size:14px;color:#242424;font-weight:400;">
                        Електронна адреса - <span> {{ $demo->email }}</span>
                    </p>
                    <p style="font-size:14px;color:#242424;font-weight:400;">
                        Бюджет проекту - <span>{{ $demo->budjet }}</span>
                    </p>
                </div>
            </div>
            <div style="padding:20px;">
                <p style="color:aaa;font-size:14px;margin:0px;display:inline-block;">Дякуємо за
                    заявку<br><b>{{ $demo->sender }}</b></p>
            </div>
        </div>
    </div>
</body>

</html>
