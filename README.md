# 🏫 Desafio AWS - Cadastro de Alunos

Este projeto é um sistema simples de cadastro de alunos desenvolvido em **PHP**, **HTML/Bootstrap** e **MariaDB**, pronto para rodar em uma instância **EC2 Ubuntu**.

O sistema permite inserir dados de alunos através de um formulário web e armazená-los no banco de dados.

---

## 🔧 Pré-requisitos

* EC2 Ubuntu Server (ex: Ubuntu 24.04 LTS)
* Apache2
* PHP >= 8.1 (`pdo_mysql`, `mbstring`, `xml`)
* MariaDB / MySQL
* Git

---

## 📥 Instalação

### 1. Atualizar Ubuntu e instalar pacotes necessários

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 php libapache2-mod-php php-mysql php-mbstring php-xml git wget unzip -y
sudo systemctl restart apache2
```

### 2. Clonar o projeto

```bash
cd /var/www/html
sudo git clone https://github.com/Candao999/desafio-aws.git
cd desafio-aws
```

Se houver problemas de permissão com Git:

```bash
sudo git config --global --add safe.directory /var/www/html/desafio-aws
```

---

## 💾 Banco de dados

### 1. Acessar MariaDB

```bash
sudo mariadb
```

### 2. Criar banco e tabela

```sql
CREATE DATABASE IF NOT EXISTS desafio;
USE desafio;

CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    isento TINYINT(1) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    periodo VARCHAR(20) NOT NULL,
    observacoes TEXT
);
```

### 3. Criar usuário e conceder permissões

```sql
CREATE USER 'desafio'@'localhost' IDENTIFIED BY 'senhaSegura';
GRANT ALL PRIVILEGES ON desafio.* TO 'desafio'@'localhost';
FLUSH PRIVILEGES;
```

> Substitua `'senhaSegura'` por uma senha segura de sua escolha.

---

## 📝 Configuração do PHP

No arquivo `index.php`, configure a conexão com o banco:

```php
$host = 'localhost';
$dbname = 'desafio';
$username = 'desafio';
$password = 'senhaSegura';
```

---

## 🌐 Uso do Formulário

1. Abra o navegador e acesse:

```
http://<IP_da_instancia>/desafio-aws/index.html
```

2. Preencha os campos do formulário e clique em **Cadastrar**.

---

## ⚡ Teste rápido pelo terminal

```bash
cd /var/www/html/desafio-aws
php -r '
$pdo = new PDO("mysql:host=localhost;dbname=desafio", "desafio", "senhaSegura");
foreach($pdo->query("SELECT * FROM alunos") as $row) { print_r($row); }
'
```

---

## 🔒 Segurança

* Use senhas fortes para o banco de dados.
* Configure **Security Groups** na AWS para restringir acesso.
* Evite usar phpMyAdmin sem SSL/TLS em produção.
* Sempre atualize o Ubuntu e pacotes PHP/MariaDB.

---

## 📂 Estrutura do projeto

```
desafio-aws/
├── index.html        # Formulário de cadastro
├── index.php         # Script PHP para gravar dados no banco
└── README.md         # Documentação
```
