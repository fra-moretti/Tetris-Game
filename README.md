# **Advanced Tetris Project**

This project brings the classic **Tetris** to life with modern features, server integration, and a sleek interface. Built with a combination of **HTML**, **CSS**, **JavaScript**, and **PHP**, it offers a seamless and interactive gaming experience that’s both fun and technically robust.

---

## **Features and Highlights**

### 🎮 **Dynamic Gameplay**
- **Modular Classes**:
  - **`Map`**: Manages the grid, block rendering, and logic for line completion and clearing.
  - **`Block`**: Handles shapes, movements, collisions, and rotations.
  - **`Game`**: Oversees interactions between grid, blocks, and game state, including level progression, scoring, and block drop speed.

- **Enhanced Controls**:
  - Pause and resume functionality with intuitive **spacebar** control.
  - Dedicated screens for pause, game-over, and rules explanation.

---

### 🌐 **Server-Side Integration with PHP**
- **Database Updates**:
  - **`aggiornaHighscore(highscore, linee, livello)`**: Sends the high score, completed lines, and level data to the server for persistent tracking.
  - **`aggiornaSaldo(ricompensa)`**: Updates the player’s virtual balance based on their score.

- **PHP APIs**:
  - Backend scripts like **`updateDB.php`** and **`scoreboard.php`** manage score saving, virtual balance, and shop purchases.

---

### 🚀 **Progression and Rewards**
- **Dynamic Levels**:
  - Levels increase as the player clears lines.
  - Falling block speed increases for added challenge.

- **Score Calculation and Bonuses**:
  - Points are awarded based on the number of lines cleared in a single move (e.g., 1 line = 40 points, 4 lines = 1200 points).
  - Virtual rewards incentivize continued gameplay.

---

### 💻 **User Interface**
- **Clean and Responsive Design**:
  - Optimized grid visuals and a preview of the next block for intuitive gameplay.
  - Interactive pause and instruction screens.

- **Seamless Backend Integration**:
  - Real-time score saving and leaderboard updates.
  - Automatic progress saving and display of the player’s virtual balance.

---

## **Main Pages**
- **`index.php`**: The entry point for login and navigation.
- **`home.php`**: Player dashboard with access to gameplay, leaderboards, and shop.
- **`scoreboard.php`**: Displays global leaderboards.
- **`shop.php`**: Allows players to purchase upgrades or customizations using virtual rewards.
- **`pause.php` and `game-over.php`**: Interactive overlays for immersive gameplay management.

---

## **Technologies Used**
1. **Frontend**: HTML, CSS, JavaScript (object-oriented).  
2. **Backend**: PHP for data handling and server-side logic.  
3. **Database**: Presumably MySQL, for storing scores and other persistent data.

---

## **Strengths**
- **Smooth Gameplay**: Managed with `requestAnimationFrame` for seamless rendering.
- **Progression and Rewards**: Keeps players engaged with increasing challenges and incentives.
- **Polished Interface**: A modern, responsive design for a pleasant user experience.
- **Backend Synchronization**: Provides a connected experience with real-time updates.

---

## **Installation**

To set up the project, follow these steps:

1. **Install and configure XAMPP**:
   - Download and install [XAMPP](https://www.apachefriends.org/index.html).
   - Ensure **Apache** and **MySQL** services are running.

2. **Set up the database**:
   - Launch the **`moretti_603552.sql`** file in your preferred database manager (e.g., phpMyAdmin) to initialize the database schema and populate necessary tables.

3. **Host the website**:
   - Place the project folder inside XAMPP's `htdocs` directory (e.g., `C:/xampp/htdocs/tetris`).

4. **Access the website**:
   - Open your browser and go to `http://localhost/tetris/index.php`.

---

## **How to Play**

1. Open the website on your browser using the URL mentioned above.
2. Log in or create a new account to start playing.
3. Use the following controls to play:
   - **Arrow keys**: Move and rotate blocks.
   - **Spacebar**: Drop blocks instantly.
   - **P**: Pause/resume the game.
4. Progress through levels by clearing lines and earning rewards!
5. Visit the shop to purchase upgrades or customizations with your in-game balance.

---

This project combines technical complexity with an engaging experience, making it perfect for both gaming enthusiasts and developers looking to showcase their full-stack skills. 🎮✨
