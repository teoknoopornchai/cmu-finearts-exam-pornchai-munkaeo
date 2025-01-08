
# ใช้ภาพของ PHP ที่ติดตั้ง Apache
FROM php:7.4-apache

# เปิดใช้ mod_rewrite ใน Apache
RUN a2enmod rewrite

# ติดตั้ง PHP extensions ที่จำเป็น (เช่น mysqli, pdo, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# คัดลอกไฟล์โปรเจกต์ไปยัง container
COPY . /var/www/html/

# ตั้งค่าให้ Apache ทำงานที่โฟลเดอร์ /var/www/html
WORKDIR /var/www/html/

# เปิดพอร์ต 80
EXPOSE 80
