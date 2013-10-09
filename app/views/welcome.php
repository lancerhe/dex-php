<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://im.crackedzone.com/resources/css/bootstrap.min.css">
<title>Welcome DEXPHP</title>
</head>

<body>
<div class="container">
    <div class="hero-unit">
        <h1><?php echo $title?></h1>
    </div>

    <div class="well">
        <p><?php echo $desc?></p>
        <p><strong>Controller File:</strong> app/controllers/Index.php</p>
        <p><strong>View File:</strong> app/views/welcome.php</p>
        <p><strong>You can see <a href="/index.php?r=article/view/">/index.php?r=article/view/</a></strong></p>
    </div>
</div>
</body>
</html>
