# 🚀 Deploy CRUD PHP ke Azure dengan Database MySQL

Panduan lengkap untuk deploy proyek CRUD PHP Native ke Azure App Service dengan MySQL Database.

## 📋 Prerequisites

- Akun Azure (Student/Free tier)
- GitHub Account
- Repository GitHub yang berisi proyek ini

---

## 🔧 Langkah 1: Buat Azure Database for MySQL

### Di Azure Portal:

1. **Buat MySQL Flexible Server**
   - Search "Azure Database for MySQL"
   - Klik **Create** > **Flexible server**
   
2. **Konfigurasi Server:**
   - **Resource group**: Buat baru atau pilih existing
   - **Server name**: `crud-yasmin-db` (atau nama lain)
   - **Region**: Southeast Asia (atau terdekat)
   - **MySQL version**: 8.0
   - **Compute + storage**: 
     - Pilih **Burstable, B1s** (paling murah)
     - Storage: 20 GB
   
3. **Authentication:**
   - **Admin username**: `adminuser` (catat ini)
   - **Password**: Buat password kuat (catat ini)
   
4. **Networking:**
   - **Connectivity method**: Public access
   - ✅ Centang: **Allow public access from any Azure service**
   - ✅ Add **0.0.0.0 - 255.255.255.255** (untuk development)
   
5. Klik **Review + create** > **Create**

### Import Database:

1. **Connect ke MySQL:**
   - Download **MySQL Workbench** atau gunakan Azure Cloud Shell
   - Connection string: `<server-name>.mysql.database.azure.com`
   
2. **Import database.sql:**
   ```sql
   CREATE DATABASE IF NOT EXISTS crud_yasmin;
   USE crud_yasmin;
   -- Copy isi dari database.sql
   ```

---

## 🌐 Langkah 2: Buat Azure App Service

### Di Azure Portal:

1. **Create Web App**
   - Search "App Services"
   - Klik **Create** > **Web App**

2. **Konfigurasi:**
   - **Resource Group**: Pilih yang sama dengan database
   - **Name**: `crud-yasmin-app` (harus unik)
   - **Publish**: Code
   - **Runtime stack**: PHP 8.0
   - **Operating System**: Linux
   - **Region**: Southeast Asia (sama dengan database)
   
3. **App Service Plan:**
   - **Pricing plan**: 
     - Pilih **Free F1** atau **Basic B1**
     - Jika error quota, gunakan region lain
   
4. Klik **Review + create** > **Create**

---

## ⚙️ Langkah 3: Konfigurasi Environment Variables

### Di App Service:

1. Buka **App Service** yang baru dibuat
2. Pilih **Configuration** di menu kiri
3. Klik **New application setting** dan tambahkan:

```
DB_HOST = crud-yasmin-db.mysql.database.azure.com
DB_USER = adminuser
DB_PASS = <password-yang-dibuat>
DB_NAME = crud_yasmin
```

4. Klik **Save** > **Continue**

---

## 🔐 Langkah 4: Setup GitHub Deployment

### A. Buat Service Principal di Azure

Di **Azure Cloud Shell** (bash), jalankan:

```bash
# Login ke Azure
az login

# Dapatkan Subscription ID
az account show --query id -o tsv

# Buat Service Principal dengan Federated Identity
az ad sp create-for-rbac --name "crud-yasmin-sp" \
  --role Contributor \
  --scopes /subscriptions/<SUBSCRIPTION_ID>/resourceGroups/<RESOURCE_GROUP>
```

**Catat output:**
- `appId` (AZURE_CLIENT_ID)
- `tenant` (AZURE_TENANT_ID)
- `password` (tidak perlu untuk OIDC)

### B. Setup Federated Credentials

1. Buka **Azure Active Directory** > **App registrations**
2. Cari dan klik aplikasi `crud-yasmin-sp`
3. Pilih **Certificates & secrets** > **Federated credentials**
4. Klik **Add credential** > **GitHub Actions**

**Isi form:**
```
Organization: <username-github-anda>
Repository: crud-yasmin (atau nama repo anda)
Entity type: Branch
Branch name: main
Name: github-deploy
```

### C. Setup GitHub Secrets

Di repository GitHub:

1. **Settings** > **Secrets and variables** > **Actions**
2. Klik **New repository secret**, tambahkan:

```
AZURE_CLIENT_ID = <appId dari step A>
AZURE_TENANT_ID = <tenant dari step A>
AZURE_SUBSCRIPTION_ID = <subscription ID>
```

### D. Update Workflow File

Edit `.github/workflows/azure-deploy.yml`, ubah:

```yaml
env:
  AZURE_WEBAPP_NAME: crud-yasmin-app    # Sesuaikan dengan nama App Service
```

---

## 📤 Langkah 5: Push ke GitHub

```bash
# Initialize git (jika belum)
git init

# Add semua file
git add .

# Commit
git commit -m "Initial commit - CRUD PHP for Azure"

# Add remote (ganti dengan repo Anda)
git remote add origin https://github.com/<username>/crud-yasmin.git

# Push ke main branch
git push -u origin main
```

GitHub Actions akan otomatis deploy ke Azure!

---

## 🎯 Langkah 6: Akses Aplikasi

Setelah deployment selesai:

```
https://crud-yasmin-app.azurewebsites.net
```

---

## 🔍 Troubleshooting

### Error: MySQL Connection Failed
```bash
# Test koneksi dari Azure Cloud Shell
mysql -h crud-yasmin-db.mysql.database.azure.com -u adminuser -p
```

### Error: Quota Exceeded
- Pilih region lain (West Europe, East US, dll)
- Atau gunakan Free tier (F1)

### Error: GitHub Actions Failed
- Cek logs di GitHub Actions tab
- Pastikan semua secrets sudah benar
- Pastikan Federated Credentials sudah dibuat

### Debug Database Connection

Tambahkan di `config/database.php` (sementara):
```php
if (!$conn) {
    die("Host: " . DB_HOST . "<br>User: " . DB_USER . "<br>Error: " . mysqli_connect_error());
}
```

---

## 💰 Estimasi Biaya

**Free Tier:**
- App Service F1: **FREE**
- MySQL B1s: ~$12/month (20GB storage)

**Tips Hemat:**
- Stop MySQL server saat tidak dipakai
- Gunakan Free tier untuk development
- Delete resource setelah selesai belajar

---

## ✅ Checklist Deployment

- [ ] MySQL Flexible Server dibuat
- [ ] Database `crud_yasmin` di-import
- [ ] App Service dibuat (PHP 8.0)
- [ ] Environment variables di-set
- [ ] Service Principal dibuat
- [ ] Federated Credentials dikonfigurasi
- [ ] GitHub Secrets ditambahkan
- [ ] Workflow file diupdate
- [ ] Code di-push ke GitHub
- [ ] Deployment berhasil
- [ ] Aplikasi bisa diakses

---

## 🆘 Support

Jika ada masalah:
1. Cek GitHub Actions logs
2. Cek Azure App Service logs (Log stream)
3. Cek MySQL connectivity dari portal

Good luck! 🚀
