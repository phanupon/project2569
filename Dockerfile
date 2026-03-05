FROM php:8.2-apache

# คำสั่งสำคัญ: ติดตั้ง mysqli และเปิดใช้งาน
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# (ตัวเลือกเสริม) ถ้าจะใช้ PDO ด้วยให้ใช้บรรทัดนี้แทน:
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql