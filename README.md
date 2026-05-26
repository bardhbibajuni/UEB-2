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

* **🎨 Dynamic Mouse Glow:** Një dritë interaktive ndjek kursorin e miut në të gjithë faqen.
* **🛡️ Secure Downloads:** Skedari `download.php` mbron materialet; askush nuk mund të shkarkojë një skedar pa e pasur kursin të blerë.
* **🗄️ MySQL me Prepared Statements:** Çdo query në DB përdor parametra të lidhur (PDO) për mbrojtje nga SQL Injection.
* **🔒 XSS Protection:** Çdo input nga përdoruesi sanitizohet automatikisht me `htmlspecialchars`.

---

## ⚙️ Çfarë u shtua në FAZA II

### Integrimi me MySQL
* 4 tabela me relacione: `users`, `courses`, `purchases`, `contact_messages`.
* CRUD i plotë për kurset dhe përdoruesit me **prepared statements**.

### Siguria
* SQL Injection: PDO + prepared statements në çdo query.
* XSS: `sanitize()` për çdo output dhe input.
* Validim server-side (length, format, role).
* `password_hash()` + `password_verify()` për fjalëkalimet.
* CSRF token helper.
* Session regenerate ID në login, pastrim cookies në logout.
* MIME type check për file upload.

### Koncepte të avancuara
* File handling: upload PDF/Video me kontroll të extension dhe MIME (max 200MB).
* Error handling me `try/catch` në çdo veprim DB.
* Email përmes formes së kontaktit (`mail()` në `contact.php`).

### AJAX & Web API
* **AJAX CRUD** (pa refresh):
  * `ajax/delete_course.php` – fshirje kursi.
  * `ajax/search_courses.php` – live search.
  * `ajax/toggle_user_role.php` – update i rolit.
  * `ajax/check_email.php` – kontroll i emailit në regjistrim.
* **Web API i jashtëm:** `ajax/get_quote.php` lidhet me `api.adviceslip.com` për të marrë një këshillë në dashboard.

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
