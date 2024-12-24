# Menggunakan image PHP dengan Apache
FROM php:8.0-apache
RUN apt-get update && apt-get install -y default-mysql-client
RUN chmod -R 755 /var/www/html


# Menyalin kode aplikasi ke direktori yang digunakan Apache
COPY ./src /var/www/html/

# Menginstall ekstensi mysqli untuk PHP
RUN docker-php-ext-install mysqli

# Memberi izin pada direktori agar dapat diakses oleh Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80