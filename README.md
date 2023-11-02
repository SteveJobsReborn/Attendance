# Attendance System

# Installation
- clone the file to your working directory via command:
```
git clone https://github.com/SteveJobsReborn/Attendance.git
```

# Prequisities
- Install Xampp program in your machine via https://www.apachefriends.org/

# Setup Xampp Virtual Host
- replace the following "yourfilepath" with your working directory
- paste the following code to /xampp/apache/conf/extra/httpd-vhosts.conf :
```
<VirtualHost *:80>
    ServerAdmin attendance.local
    DocumentRoot "C:/yourfilepath/"
    ServerName attendance.local
    ServerAlias www.yourproject.dev
    <Directory "C:/yourfilepath/">
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




