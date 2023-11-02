# Attendance System

# Setup Xampp Virtual Host
- replace the following with your file path
- paste the following code to /xampp/apache/conf/extra/httpd-vhosts.conf :
```
<VirtualHost *:80>
    ServerAdmin attendance.local
    DocumentRoot "C:/yourfilepathhere/"
    ServerName attendance.local
    ServerAlias www.yourproject.dev
    <Directory "C:/yourfilepathhere">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
- add the following line to EOF of C:\Windows\System32\drivers\etc\hosts :
```
127.0.0.1 attendance.local
```
- If everything setup correctly, you can now simply open your browser and enter http://attendance.local to access the website




