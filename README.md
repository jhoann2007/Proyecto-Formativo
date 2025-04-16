# 🏋️ SenGym - Proyecto Formativo 🏋️

Welcome to SenGym, a web application project developed as part of a formative process. This application aims to provide functionalities related to gym management.

---

## ✨ Sneak Peek! ✨
███████████ ███████████
█ █ █ █
█ ██████████ █
█ █ █ █
███████████ ███████████
███ ███
███ ███
███ S E N G Y M ███
███ ███
███ ███
███████████ ███████████
█ █ █ █
█ ██████████ █
█ █ █ █
███████████ ███████████

**(Optional: Replace with an actual GIF!)**
<!-- 
[![SenGym Demo GIF](https://via.placeholder.com/600x300.png?text=Add+Project+Demo+GIF+Here)](https://your-deployment-link-or-video.com)
*Replace the placeholder above with a link to a GIF or video showcasing your project!* 
-->

---

## 🚀 Features

Based on the project structure, potential features include:

*   **User Profiles:** Viewing and potentially managing user information (`perfil.php`).
*   **Apprentice Management:** Adding new apprentices/users (`agregarAprendiz.php`).
*   **Calendar/Scheduling:** Displaying a calendar (`calendario.php`).
*   **Modular Design:** Using includes for common sections like header, footer, scripts (`config/`).
*   **Responsive Frontend:** Built with Bootstrap for adaptability across devices.
*   **Engaging UI:** Utilizes libraries like AOS (Animate On Scroll), Glightbox, and SwiperJS.

---

## 🛠️ Technologies Used

*   **Backend:** PHP
*   **Frontend:**
    *   HTML5
    *   CSS3
    *   JavaScript
    *   [Bootstrap 5](https://getbootstrap.com/)
    *   [Bootstrap Icons](https://icons.getbootstrap.com/)
    *   [AOS (Animate On Scroll)](https://michalsnik.github.io/aos/)
    *   [Glightbox](https://biati-digital.github.io/glightbox/)
    *   [SwiperJS](https://swiperjs.com/)
    *   [Google Fonts](https://fonts.google.com/)
*   **Development Tools:** (Add any specific tools like VS Code, Composer, etc.)
*   **Database:** (Mention if the `bd` folder contains database setup/scripts - e.g., MySQL, PostgreSQL)

---

## 📁 Project Structure

The project follows a structure separating public-facing files from application logic:


**Important:** For the web server (like Apache or Nginx), the **`public/`** directory should be set as the **Document Root**. Assets (CSS, JS, Images, Vendor files) referenced by the browser *must* reside within `public/assets/` to be accessible.

---

## ⚙️ Setup & Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/Proyecto-Formativo.git
    cd Proyecto-Formativo
    ```
2.  **Web Server:** Set up a local web server environment (e.g., XAMPP, MAMP, WAMP, Laragon, Docker with PHP/Apache/Nginx).
3.  **Configure Document Root:** Point your web server's virtual host configuration to the `public/` directory inside the cloned project folder.
4.  **Database (If applicable):**
    *   Create a database (e.g., `sengym_db`).
    *   Import any SQL files found in the `bd/` directory.
    *   Configure database connection details (check PHP files, possibly in a `config.php` or similar - you might need to create one).
5.  **Dependencies (If applicable):** If using Composer for PHP dependencies (check for `composer.json`), run:
    ```bash
    composer install
    ```
6.  **Access:** Open your web browser and navigate to the local URL configured for your web server (e.g., `http://localhost/`, `http://sengym.test/`).

---

## 🕹️ Usage

Once set up, navigate to the application's URL in your browser. Explore the different sections like the profile, calendar, and apprentice management features.

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

---

## 📜 License

Distributed under the [Your License Name] License. See `LICENSE` file for more information (or add license details here).
<!-- Example: Distributed under the MIT License. See `LICENSE.txt` for more information. -->

---

## 📧 Contact

[Your Name] - [your.email@example.com]

Project Link: [https://github.com/your-username/Proyecto-Formativo](https://github.com/your-username/Proyecto-Formativo)
