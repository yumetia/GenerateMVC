
# GenerateMVC - A Simple MVC Structure Generator

## 📌 About

**GenerateMVC** is a PHP script that creates a **predefined MVC-like folder structure** with essential files.  
This is **not** a strict implementation of the **MVC pattern**, but rather an **organization** that I personally find **complete and efficient** for PHP projects.  

## ⚡ Features

- 📂 **Creates directories**: Model, View, Controller, Helper, Config, etc.
- 📄 **Generates core files**: `.htaccess`, `autoload.php`, `index.php`.
- ✅ **Ensures structure integrity**: If a directory or file already exists, it won't be recreated.
- 🔄 **Scans existing directories** before generating new ones.

## 🛠 Installation & Usage

### 1️⃣ **Clone the repository**
```sh
git clone https://github.com/yumetia/GenerateMVC.git
cd GenerateMVC
```

### 2️⃣ **Run the script**
Make sure you have PHP installed, then execute:
```sh
php GenerateMVC.php
```
This will create the necessary folders and files.

## 🏗️ MVC Structure Generated
After execution, the following structure will be created:

```
📂 ProjectRoot/
│── 📂 Model/
│   ├── Database.php
│   ├── GenericModel.php
│── 📂 View/
│   ├── 📂 assets/
│   ├── 📂 content/
│   ├── 📂 css/
│   │   ├── components/
│   │   ├── global/
│   │   ├── pages/
│   ├── 📂 js/
│   │   ├── components/
│   │   ├── global/
│   │   ├── pages/
│── 📂 Controller/
│   ├── Login.php
│   ├── Register.php
│── 📂 Helper/
│   ├── HtmlHelper.php
│   ├── Redirect.php
│── 📂 Config/
│   ├── config.ini
│   ├── import.php
│   ├── db.sql
│── 📄 .htaccess
│── 📄 autoload.php
│── 📄 index.php
```

## 🛠 Customization
You can modify the `$mvcStructure` array in `GenerateMVC.php` to adapt the structure to your project needs.

## 🚀 Contributions & Feedback
Feel free to **fork**, submit **issues**, or **contribute** if you have improvements or suggestions!  
Your feedback is always welcome.  

---

**🔗 Author:** Yumetia | GitHub: [@yumetia](https://github.com/yumetia)
