# 🔎 Directory Search Tool  

This repository contains a **powerful search tool (`search.php`)** that allows users to scan an entire **web directory**. To ensure security, access to the search tool is **password-protected**, requiring authentication before use. Additionally, search queries must be **at least 3 characters long** for valid results. 🔒  

## 📁 Project Structure  

Ensure all files are correctly placed in the **root directory** for proper functionality:  

- **search.php** - The only file needed to dynamically search across the entire web directory. **Requires password authentication and a minimum query length of 3 characters.**  

---

## 📦 Installation Guide  

### 1️⃣ **Download & Place Files in Root Directory**  

Choose one of the following methods to get the project file:  

- **Option 1: Clone the Repository (Recommended)**  
  - Open a terminal or command prompt and run:  
    ```sh
    git clone https://github.com/vsuin/Directory-Search.git
    ```
    
- **Option 2: Download Manually**  
  - Visit **[GitHub Repository](https://github.com/vsuin/Directory-Search.git)**  
  - Click **"Code"** → **"Download ZIP"**  
  - Extract the ZIP file and place `search.php` in your **website’s root directory**  

---

### 2️⃣ **Start Local or Live Server**  
- **Local Testing:** Ensure **Apache & PHP** are enabled in **XAMPP, WAMP, or other local servers**  
- **Live Deployment:** Upload `search.php` to your **website’s root directory** via FTP or hosting panel  

---

### 3️⃣ **Set Up Password Authentication & Search Validation**  
- Open `search.php` in a text editor  
- Locate the authentication section and set your **desired password**  
- Ensure the **minimum search query length** is set to **3 characters** to prevent invalid searches  

---

### 4️⃣ **Access the Search Tool**  
- Open your **website URL**, then navigate to the search tool:  
  👉 `http://yourwebsite.com/search.php`  
- Enter the **password** to unlock the search functionality  
- Perform a **keyword or filename search** (must be **at least 3 characters long**), and relevant results will be displayed dynamically! 🔍  

---


## ⚡ Troubleshooting  

- **Incorrect password?** Ensure you have set the correct password in `search.php`  
- **Search query too short?** Enter at least **3 characters** before submitting a search request  
- **No results?** Verify that `search.php` has access to the correct directories  
- **Search tool not working?** Ensure **PHP** is enabled and functioning  

---

