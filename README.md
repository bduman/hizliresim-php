# hizliresim.com serverlarına uzaktan görsel yükleme

### Class hakkında

bmp, tiff ve webp dönüşümleri bulunmaktadır. Chrome eklentisi üzerinden oluşturulmuştur.


### Kullanımı
```sh
require_once '../class/hizliresim.class.php';
```

### Hızlıresim direkt link ulaşımı için kullanım
```sh
$hizliResim = new Hizliresim();
```

```sh
array(2) {
  [0]=>
  string(34) "http://i.hizliresim.com/XkENlD.jpg"
  [1]=>
  string(34) "http://i.hizliresim.com/bDLp9j.gif"
}
```

### Hızlıresim'den dönen veriyi döndürmek için
```sh
$hizliResim = new Hizliresim(true);
```

```sh
array(1) {
  [0]=>
  array(1) {
    ["images"]=>
    array(1) {
      [0]=>
      array(3) {
        ["status"]=>
        int(0)
        ["source_url"]=>
        string(53) "http://materializecss.com/images/starter-template.gif"
        ["image_url"]=>
        string(28) "http://hizliresim.com/LAONRV"
      }
    }
  }
}
```

### Biriktirip toplu yükleme
```sh
// part 1
$hizliResim->collect(array(
    "http://materializecss.com/images/starter-template.gif",
    "http://materializecss.com/images/starter-template.gif"
));
// part 2
$hizliResim->collect("http://materializecss.com/images/parallax-template.jpg");
// multi curl
$collect = $hizliResim->go();

// output
var_dump($collect);
```
```sh
array(3) {
  [0]=>
  string(34) "http://i.hizliresim.com/g89ppZ.gif"
  [1]=>
  string(34) "http://i.hizliresim.com/9oDAAo.gif"
  [2]=>
  string(34) "http://i.hizliresim.com/PkONN6.jpg"
}
```
### Tek tek yükleme
```sh
$single = $hizliResim->upload("http://materializecss.com/images/starter-template.gif");

// output
var_dump($single);
```

### Paralel yükleme
```sh
$multi = $hizliResim->upload(array(
    "http://materializecss.com/images/parallax-template.jpg",
    "http://materializecss.com/images/starter-template.gif"
));

// output
var_dump($multi);
```
