# acreditacion
Web system for document management of the accreditation process of university courses at the University of Matanzas. It is a customization of the Veno File Manager application. To deploy it in the Debian operating system with an Apache web server, the following steps must be followed:

* The accreditation.zip file is decompressed or the repository is cloned.

* A symbolic directory link is created with the /var/www/html directory with the following command:

		ln -s /<path>/acreditacion /var/www/html/acreditacion.cidra.cu

* Create a virtual host with the following command:

		cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/acreditacion.cidra.cu.conf 

* Open the file with the following command:

		nano /etc/apache2/sites-available/acreditacion.cidra.cu.conf

* Edit the content of the file and place the following:

		<VirtualHost *:80>
			ServerName acreditacion.cidra.cu
			ServerAlias acreditacion.cidra.cu

			ServerAdmin webmaster@localhost
			DocumentRoot /var/www/html/acreditacion.cidra.cu

			ErrorLog ${APACHE_LOG_DIR}/error.log
			CustomLog ${APACHE_LOG_DIR}/access.log combined

		</VirtualHost>

* Save and close the file

* Enable the virtual host

		a2ensite  /etc/apache2/sites-available/acreditacion.cidra.cu.conf

* Restart the Apache server

		/etc/init.d/apache2 restart

* Open the file with the following command:

		nano /etc/hosts

* Edit the content of the file and add line:

		127.0.1.1       acreditacion.cidra.cu

* Save and close the file

* We open a web browser and enter the address http://acreditacion.cidra.cu/
