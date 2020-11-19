# PHP 7 Notes

Khaled Alam's notes. Ref: books, articles, discussions, my experience.<br>

Reach me out: <a href="mailto:khaledalam.net@gmail.com">khaledalam.net@gmail.com</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="https://linkedin.com/in/khaledalam">LinkedIn</a><br><br>

<img src="php7.jpg"><Br><br>

---
<br><br>

## 👁  New Features in PHP 7
<br>

### 👉 Type hints

```php

<?php

// scalar type hints are nonrestrictive
function age(int $age)
{
    return $age;
}

echo age(10) . PHP_EOL;   // 10
echo age(10.5) . PHP_EOL; // 10

?>
```


```php
<?php

declare(strict_types = 1);

// scalar type hints are nonrestrictive
function age(int $age)
{
    return $age;
}

echo age(10) . PHP_EOL;   // 10
echo age(10.5) . PHP_EOL; // PHP Fatal error:  Uncaught TypeError: Argument 1 passed to age() must be of the type int, float given

?>

```

<br>

### 👉 Namespaces and group use declarations


```php
use Some\Namespace\{ Class_1, Class_2 };
use function Some\Namespace\{ Func_1, Func_2 };
use const Some\Namespace\{ CONST_1, CONST_2 };
```
```php
use Some\Namespace\{ 
    Class_1,
    Class_2,
    function Func_1,
    function Func_2,
    const CONST_1,
    const CONST_2 
};
```

>> In PHP, it is not required to divide classes in subfolders
according to their namespace, as is the case with other
programming languages. Namespaces just provide a logical
separation of classes. However, we are not limited to placing
our classes in subfolders according to our namespaces.


<br>

### 👉 The anonymous classes

```php

$myName = new class('Khaled Alam') {
    public function __construct(string $name)
    {
        echo $name;
    }
};
// Khaled Alam
```

<br>

### 👉 Old-style constructor deprecation
```php
class Khaled{
    public function __construct()
    {
        echo "is this constructor now?";
    }

    // this is normal function since __construct is existed in the class, otherwidse it will be considered as constructor and it will show a deprecated message.
    public function khaled()
    {
        echo "is this constructor now?";
    }
}
```

<br>

### 👉 The Spaceship operator


`<=>`
```
- It returns 0 if both the operands on left- and right-hand sides are equal

- It returns -1 if the right operand is greater than the left operand

- It returns 1 if the left operand is greater than the right one
```

```php
function sort1($a, $b) : int
{
    if( $a == $b )
        return 0;
    
    if( $a < $b )
        return -1;

    return 1;
}

// and

function sort2($a, $b) : int 
{
    return $a <=> $b;
}

// are equals!

echo(sort1(10, 15)); // -1
echo(sort1(15, 10)); // 1
echo(sort1(10, 10)); // 0



echo(sort2(10, 15)); // -1
echo(sort2(15, 10)); // 1
echo(sort2(10, 10)); // 0
```

<br>

### 👉 The null coalesce operator

`??`
```php
// if $_GET['name'] not set or is null then $name will be equal 'Khaled Alam'
$name = $_GET['name'] ?? 'Khaled Alam';
```

<br>


### 👉 Uniform variable syntax
```php
$varName = 'name';

$name = 'Khaled Alam';

echo ${$varName}; // Khaled Alam
```
<br>

### 👉 Miscellaneous changes

const array

```php
define('currency', ['dollar', 'euro']);
```
multiple default cases

`session_start( [ ] )` override the session settings in the php.ini file.


<br>


### 👉 IntlChar

You need to have Intl extension installed.

```php
echo IntlChar::charName('!') . PHP_EOL; // EXCLAMATION MARK

echo (IntlChar::isWhitespace(' ') ? 'Yes' : 'No') . PHP_EOL; // Yes
```

<br>



--------

<br><br>

## 👁 Performance
<br><br>

### 👉 Caching static files 


> Apache `in (.htaccess file)`

```apacheconf
<FilesMatch "\.(ico|jpg|jpeg|png|gif|css|js|woff)$">
Header set Cache-Control "max-age=604800, public
</FileMatch>
```
`604800 = 7days`
<br><br>

> NGINX `in (/etc/nginx/sites-available/your-virtual-host-conf-file)`

```apacheconf
Location ~* .(ico|jpg|jpeg|png|gif|css|js|woff)$ {
Expires 7d;
}
```

<br>

### 👉 HTTP keep-alive

>> In HTTP keep-alive, a single TCP/IP connection is
used for multiple requests or responses. It has a huge performance improvement over the normal connection as it uses only a single connection instead of opening and closing connections for each and every single request or response.

- The load on the CPU and memory is reduced.
- Network congestion is reduced.
- Reduces latency in subsequent requests after the TCP connection is
established.

> Apache `in (.htaccess file)`

```apacheconf
<ifModule mod_headers.c>
Header set Connection keep-alive
</ifModule>

KeepAlive On
MaxKeepAliveRequests 100 (0 = unlimited)
KeepAliveTimeout 100
```

> NGINX `in (/etc/nginx/sites-available/your-virtual-host-conf-file)`

```apacheconf
keepalive_requests 100
keepalive_timeout 100
```

<br>

### 👉 GZIP compression
>> Content compression provides a way to reduce the contents' size delivered by the
HTTP server. Both Apache and NGINX provide support for GZIP compression, and
similarly, most modern browsers support GZIP. When the GZIP compression is
enabled, the HTTP server sends compressed HTML, CSS, JavaScript, and images
that are small in size. This way, the contents are loaded fast.

> Apache `in (.htaccess file)`

```apacheconf
<IfModule mod_deflate.c>
SetOutputFilter DEFLATE
#Add filters to different content types
AddOutputFilterByType DEFLATE text/html text/plain text/xml
text/
css text/javascript application/javascript
#Don't compress images
SetEnvIfNoCase Request_URI \.(?:gif|jpe?g|png)$ no-gzip dont-
vary
</IfModule>
```

> NGINX `in (/etc/nginx/sites-available/your-virtual-host-conf-file)`
```apacheconf
gzip on;
gzip_vary on;
gzip_types text/plain text/xml text/css text/javascript application/x-
javascript;
gzip_com_level 4;
```

<br>

### 👉 Using PHP as a separate service
>> Apache used `mod_php` if we used it then we increase load of server resources (we can use PHP-FPM).
Nginx doesn't support such mods thus the PHP always used in a separate service.
<br>when we seperate php from the webserver. the webserver will forward the request to another external service which reduces the processing load on the web server.

<br>

### 👉 Disabling unused modules

> Apache
`sudo apachectl –M`

> NGINX
`sudo Nginx –V`

<br>

### 👉 Web server resources

> NGINX

>> NGINX provides two variables to adjust the resources, which are `worker_processes` and `worker_connections` . The worker_processes settings decide how many NGINX processes should run.<br><br>Now, how many `worker_processes` resources should we use? This depends on the server. Usually, it is one worker processes per processor core. So, if your server processor has four cores, this value can be set to 4.<br><br>`worker_connections` => `$ limit -u`




<br><br>

---

<br><br>

Updates and new notes are always welcomed.<br><br>


Reach me out: <a href="mailto:khaledalam.net@gmail.com">khaledalam.net@gmail.com</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="https://linkedin.com/in/khaledalam">LinkedIn</a>