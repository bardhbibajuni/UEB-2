# 🧠 Brain Boost - Full-Stack E-Learning Platform

**Brain Boost** është një sistem modern i menaxhimit të nxënies (LMS) i ndërtuar me **PHP Native**. Ky aplikacion shërben si një platformë digjitale ku përdoruesit mund të zbulojnë, blejnë dhe ndjekin kurse profesionale përmes një ndërfaqeje futuristike dhe të sigurt.

---

## 📸 Pamja e Platformës (User Experience)

Këtu janë pamjet reale nga aplikacioni, duke treguar rrjedhën e punës nga Login-i deri te studimi i kursit:

| 🏠 Faqja Kryesore (Hero Section) | 🔑 Identifikimi (Login si User) |
|---|---|
| ![Home Page](img/Screenshot%202026-04-26%20162102.png) | ![Login Page](img/Screenshot%202026-04-26%20162237.png) |
| *Ndërfaqja moderne me efekte Glassmorphism.* | *Sistemi i sigurt i kyçjes për përdoruesit.* |

| 📚 Katalogu i Kurseve | 👤 Dashboard i Përdoruesit |
|---|---|
| ![Courses Grid](img/Screenshot%202026-04-26%20162216.png) | ![User Dashboard](img/Screenshot%202026-04-26%20162048.png) |
| *Lista e kurseve me opsionin për blerje.* | *Paneli ku përdoruesi sheh kurset e veta.* |

---

## 🛠 Çfarë ofron Brain Boost?

Ky aplikacion është projektuar për të ofruar një përvojë të thjeshtë por të fuqishme për dy lloje përdoruesish:

### 1. Eksperienca e Përdoruesit (User/Student)
* **Browsing & Search:** Përdoruesi mund të kërkojë kurse në kohë reale sipas interesit.
* **Sistemi i Blerjes:** Kur klikon "Buy Now", kursi shtohet në koleksionin personal.
* **Mësimi Interaktiv:** Mundësi për të parë video (YouTube Embed) dhe materiale PDF direkt në platformë.
* **My Courses:** Një seksion i dedikuar ku listohen vetëm kurset e blera nga përdoruesi.

### 2. Eksperienca e Administratorit
* **Menaxhimi i Plotë (CRUD):** Shtimi, modifikimi dhe fshirja e kurseve.
* **File Upload:** Ngarkimi i dokumenteve dhe videove deri në **200MB**.
* **Storage Optimization:** Kur një kurs fshihet, sistemi fshin edhe skedarin fizik nga serveri.

---

## 🚀 Veçoritë "On Top" (Premium Features)

* **🎨 Dynamic Mouse Glow:** Një dritë interaktive ndjek kursorin e miut në të gjithë faqen (e krijuar me JS në `header.php`).
* **🛡️ Secure Downloads:** Skedari `download.php` mbron materialet; askush nuk mund të shkarkojë një skedar pa e pasur kursin të blerë.
* **⚡ Flat-File Database:** Nuk kërkohet SQL! Të dhënat ruhen në skedarë PHP të enkriptuar në folderin `/data`, duke e bërë aplikacionin jashtëzakonisht të shpejtë.
* **🔒 XSS Protection:** Çdo input nga përdoruesi sanitizohet automatikisht për të parandaluar sulmet kibernetike.

---

## 📂 Struktura e Kodit (VS Code)

Siç shihet në organizimin tonë të punës:
![VS Code Structure](img/Screenshot%202026-04-26%20162257.png)

* **`helpers.php`**: Truri i aplikacionit (Data management & Security).
* **`style.css`**: Stilizimi i plotë me animacione dhe efekte dritash.
* **`course_view.php`**: Player-i i integruar i mësimeve.

---

## 💻 Si ta përdorni?

1.  Vendoseni projektin në serverin tuaj lokal (XAMPP/htdocs).
2.  Sigurohuni që folderat `/data` dhe `/uploads` kanë leje shkrimi.
3.  Hapni `localhost/brain-boost`.
4.  **Për Admin:** Përdorni `admin@brainboost.com` / `Admin123!`.
5.  **Për User:** Regjistrohuni si përdorues i ri dhe filloni mësimin!

---
**Zhvilluar nga Brain Boost Team — Learn smarter. Build faster.**
