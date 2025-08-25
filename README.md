# 🚀 Desafio AWS - Prática 4  
## Instalar e Configurar um Servidor LAMP no Amazon Linux 2023  

Este projeto descreve os procedimentos para instalar e configurar um servidor **LAMP** (Linux, Apache, MariaDB e PHP) em uma instância **Amazon Linux 2023 (AL2023)** na AWS.  

O objetivo é criar um ambiente capaz de hospedar um site estático ou uma aplicação PHP dinâmica que se conecta a um banco de dados.  

---

## 📌 Etapas do Desafio

### 🔹 Etapa 1: Preparar o servidor LAMP  
- Atualizar pacotes do sistema:  
  ```bash
  sudo dnf upgrade -y
  ```
- Instalar Apache, PHP e dependências:  
  ```bash
  sudo dnf install -y httpd wget php-fpm php-mysqli php-json php php-devel
  ```
- Instalar MariaDB:  
  ```bash
  sudo dnf install mariadb105-server
  ```
- Iniciar e habilitar o Apache:  
  ```bash
  sudo systemctl start httpd
  sudo systemctl enable httpd
  ```
- Configurar permissões de `/var/www/html` para o usuário `ec2-user`.

---

### 🔹 Etapa 2: Testar o servidor LAMP  
- Criar um arquivo de teste PHP:  
  ```bash
  echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
  ```
- Acessar no navegador:  
  ```
  http://<DNS-público-da-instância>/phpinfo.php
  ```
- Excluir o arquivo após o teste por questões de segurança:  
  ```bash
  rm /var/www/html/phpinfo.php
  ```

---

### 🔹 Etapa 3: Proteger o servidor de banco de dados  
- Iniciar MariaDB:  
  ```bash
  sudo systemctl start mariadb
  ```
- Executar configuração de segurança:  
  ```bash
  sudo mysql_secure_installation
  ```
  - Definir senha para o usuário root  
  - Remover usuários anônimos  
  - Desabilitar login remoto do root  
  - Remover banco de dados de teste  

---

### 🔹 Etapa 4: Configurar SSL/TLS  
- Instalar dependências:  
  ```bash
  sudo dnf install -y openssl mod_ssl
  ```
- Criar certificado autoassinado:  
  ```bash
  sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048   -keyout /etc/pki/tls/private/apache-selfsigned.key   -out /etc/pki/tls/certs/apache-selfsigned.crt
  ```
- Reiniciar Apache:  
  ```bash
  sudo systemctl restart httpd
  ```
- Acessar via `https://<DNS-público-da-instância>`

⚠️ **Nota**: Certificados autoassinados são apenas para teste. Para produção, utilize certificados válidos emitidos por uma CA confiável.

---

### 🔹 Etapa 5: Instalar phpMyAdmin  
- Instalar dependências:  
  ```bash
  sudo dnf -y install php-mbstring php-xml
  ```
- Reiniciar serviços:  
  ```bash
  sudo systemctl restart httpd
  sudo systemctl restart php-fpm
  ```
- Configurar phpMyAdmin (colocar arquivos em `/var/www/html/phpmyadmin`).

---

## ✅ Resultado Esperado  
Ao final das etapas:  
- O Apache estará servindo páginas em HTTP e HTTPS.  
- O PHP estará funcionando corretamente com suporte a MySQL/MariaDB.  
- O banco MariaDB estará protegido e pronto para uso.  
- O phpMyAdmin estará disponível para administração do banco.  

---

## 🔒 Observações de Segurança  
- Evite abrir portas públicas desnecessárias (use apenas **22, 80 e 443**).  
- Nunca use `0.0.0.0/0` em produção para acesso SSH.  
- Utilize certificados TLS válidos em ambientes de produção.  

---

## 📚 Referências  
- [Documentação AWS - Amazon Linux 2023](https://docs.aws.amazon.com/linux/al2023/)  
- [Apache HTTP Server](https://httpd.apache.org/)  
- [MariaDB Documentation](https://mariadb.org/)  
- [PHP Official Docs](https://www.php.net/docs.php)  
- [phpMyAdmin Documentation](https://www.phpmyadmin.net/)  

---
