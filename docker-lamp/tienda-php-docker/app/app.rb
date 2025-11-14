Options Indexes FollowSymLinks
AllowOverride All
Require all granted
<IfModule mod_rewrite.c>
RewriteEngine On
# ejemplo de redirección simple a public/index.php si fuese necesario
# RewriteCond %{REQUEST_FILENAME} !-f
# RewriteCond %{REQUEST_FILENAME} !-d
# RewriteRule ^ index.php [QSA,L]
</IfModule>