document.addEventListener('DOMContentLoaded', function () {
    const game = new Game();
});

function getRandomShape() {
    const randomIndex = Math.floor(Math.random() * SHAPES.length);
    return SHAPES[randomIndex];
}


const MAP_WIDTH = 10;
const MAP_HEIGHT = 20;

const SHAPES = [
    [[1, 0, 0], [1, 1, 1]],              // J-block
    [[1, 1], [1, 1]],                   // O-block
    [[0, 1, 1], [1, 1, 0]],             // S-block
    [[1, 1, 1, 1]],                      // I-block
    [[1, 1, 1], [0, 1, 0]],             // T-block
    [[0, 0, 1], [1, 1, 1]],            // L-block
    [[1, 1, 0], [0, 1, 1]]             // Z-block
];

function getShapeName(block) {
    const shape = block.shape;

    switch (shape) {
        case SHAPES[0]:
            return "shape-J";
        case SHAPES[1]:
            return "shape-O";
        case SHAPES[2]:
            return "shape-S";
        case SHAPES[3]:
            return "shape-I";
        case SHAPES[4]:
            return "shape-T";
        case SHAPES[5]:
            return "shape-L";
        case SHAPES[6]:
            return "shape-Z";
        default:
            return "";
    }
}
/*----------------------MAP CLASS-------------------------*/

class Map {
    constructor(width, height, game) {
        this.width = MAP_WIDTH;
        this.height = MAP_HEIGHT;
        this.grid = this.createGrid();
        this.game = game;
    }

    createGrid() {
        const grid = [];
        for (let row = 0; row < this.height; row++) {
            const rowArray = [];
            for (let col = 0; col < this.width; col++) {
                rowArray.push(0);
            }
            grid.push(rowArray);
        }
        return grid;
    }

    updateGrid() {
        const gridElement = document.getElementById("grid");
        gridElement.innerHTML = "";

        for (let row = 0; row < this.height; row++) {
            for (let col = 0; col < this.width; col++) {
                const cellValue = this.grid[row][col];
                let shapeName = this.game.bloccoCorrente.currentShapeClass;
                const cellClass = cellValue === 0 ? "cell" : "cell block " + shapeName;
                const cell = document.createElement("div");
                cell.className = cellClass;
                gridElement.appendChild(cell);
            }
        }
    }

    drawBlock(blocco) {
        blocco.shape.forEach((row, rIndex) => {
            row.forEach((cell, cIndex) => {
                if (cell === 1) {
                    const rowPos = blocco.y + rIndex;
                    const colPos = blocco.x + cIndex;
                    if (rowPos >= 0 && rowPos < this.height && colPos >= 0 && colPos < this.width) {
                        this.grid[rowPos][colPos] = 1;
                    }
                }
            });
        });
    }

    clearBlock(blocco) {
        blocco.shape.forEach((row, rIndex) => {
            row.forEach((cell, cIndex) => {
                if (cell === 1) {
                    const rowPos = blocco.y + rIndex;
                    const colPos = blocco.x + cIndex;
                    if (rowPos >= 0 && rowPos < this.height && colPos >= 0 && colPos < this.width) {
                        this.grid[rowPos][colPos] = 0;
                    }
                }
            });
        });
    }

    isRowCompleted(row) {
        for (let col = 0; col < this.width; col++) {
            if (this.grid[row][col] !== 1) {
                return false;
            }
        }
        return true;
    }

    clearRow(row) {
        this.grid.splice(row, 1);
        this.grid.unshift(new Array(this.width).fill(0));
    }

    clearCompletedRows() {
        let completedRows = 0;

        for (let row = this.height - 1; row >= 0; row--) {
            if (this.isRowCompleted(row)) {
                this.clearRow(row);
                row++;
                completedRows++;
            }
        }

        if (completedRows > 0) {
            this.updateGrid();
            this.game.increaseCompletedRows(completedRows);
        }
    }

    getShapeName(row, col) {
        for (const shapeInfo of SHAPES) {
            const shape = shapeInfo.shape;
            if (shape && row >= 0 && col >= 0 && row < shape.length && col < shape[0].length && shape[row][col] === 1) {
                return shapeInfo.name;
            }
        }
        return "";
    }
}

/*----------------------TIMER CLASS-------------------------*/

class Timer {
    constructor(callback, interval) {
        this.callback = callback;
        this.interval = interval;
        this.timerID = null;
    }

    start() {
        if (!this.timerID) {
            this.timerID = setInterval(this.callback, this.interval);
        }
    }

    stop() {
        clearInterval(this.timerID);
        this.timerID = null;
    }
}

/*----------------------BLOCK CLASS-------------------------*/

class Block {

    constructor(shape, map, game) {
        this.shape = shape;
        this.x = Math.floor(MAP_WIDTH / 2) - Math.floor(shape[0].length / 2);
        this.y = -1;
        this.rotationIndex = 0;
        this.map = map;
        this.game = game;
        this.currentShapeClass = getShapeName(this);
    }

    moveLeft() {
        this.x -= 1;
    }

    moveRight() {
        this.x += 1;
    }

    moveDown() {
        this.y += 1;
    }

    moveUp() {
        this.y -= 1;
    }

    rotate() {
        const numRows = this.shape.length;
        const numCols = this.shape[0].length;
        const shapeClass = this.currentShapeClass;
        const tempShape = Array.from({ length: numCols }, function () {
            return Array(numRows).fill(0);
        });

        for (let r = 0; r < numRows; r++) {
            for (let c = 0; c < numCols; c++) {
                tempShape[c][numRows - 1 - r] = this.shape[r][c];
            }
        }

        if (!this.checkCollisionWithNewShape(tempShape, this.x, this.y)) {
            this.shape = tempShape;
            this.currentShapeClass = shapeClass;
        }
    }

    checkCollisionWithNewShape(newShape, newX, newY) {
        for (let r = 0; r < newShape.length; r++) {
            for (let c = 0; c < newShape[r].length; c++) {
                if (newShape[r][c] === 1) {
                    const rowPos = newY + r;
                    const colPos = newX + c;

                    if (
                        rowPos >= this.map.height ||
                        colPos < 0 ||
                        colPos >= this.map.width ||
                        (rowPos >= 0 && rowPos < this.map.height && this.map.grid[rowPos] && this.map.grid[rowPos][colPos] === 1)
                    ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }


    checkCollision(mappa) {
        if (!this.shape || this.y === undefined || this.x === undefined) {
            return false;
        }
        for (let r = 0; r < this.shape.length; r++) {
            for (let c = 0; c < this.shape[r].length; c++) {
                if (this.shape[r][c] === 1) {
                    const rowPos = this.y + r;
                    const colPos = this.x + c;

                    if (
                        rowPos >= mappa.height ||
                        colPos < 0 ||
                        colPos >= mappa.width ||
                        (rowPos >= 0 && rowPos < mappa.height && mappa.grid[rowPos] && mappa.grid[rowPos][colPos] === 1)
                    ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    settle(mappa) {
        const newShape = this.game.nextShape;
        const newNextShape = getRandomShape();
        this.game.nextShape = newNextShape;
        this.game.drawNextPiece(newNextShape);
        this.clearCurrentBlockFromMap(mappa);

        for (let r = 0; r < this.shape.length; r++) {
            for (let c = 0; c < this.shape[r].length; c++) {
                if (this.shape[r][c] === 1) {
                    const rowPos = this.y + r;
                    const colPos = this.x + c;
                    if (rowPos >= 0) {
                        if (rowPos >= 0 && rowPos < mappa.height) {
                            mappa.grid[rowPos][colPos] = 1;
                        }
                    }
                }
            }
        }

        mappa.clearCompletedRows();
        mappa.updateGrid();
        this.shape = newShape;
        this.currentShapeClass = getShapeName(this);
        this.x = Math.floor(MAP_WIDTH / 2) - Math.floor(newShape[0].length / 2);
        this.y = 0;
    }

    clearCurrentBlockFromMap(mappa) {
        this.shape.forEach((row, rIndex) => {
            row.forEach((cell, cIndex) => {
                if (cell === 1) {
                    const rowPos = this.y + rIndex;
                    const colPos = this.x + cIndex;
                    if (rowPos >= 0 && rowPos < mappa.height && colPos >= 0 && colPos < mappa.width) {
                        mappa.grid[rowPos][colPos] = 0;
                    }
                }
            });
        });
    }
}

/*----------------------GAME CLASS-------------------------*/

class Game {
    constructor() {

        this.gameOver = false;
        this.fallInterval = 600;
        this.lastUpdateTime = 0;
        this.completedRows = 0;
        this.level = 1;
        this.score = 0;
        this.paused = false;
        this.spaceBarEnabled = true;

        this.map = new Map(MAP_WIDTH, MAP_HEIGHT, this);
        this.timer = new Timer(this.moveBlockDown.bind(this), this.fallInterval);

        const randomShape = getRandomShape();
        this.bloccoCorrente = new Block(randomShape, this.map, this);

        this.nextShape = getRandomShape();
        this.drawNextPiece(this.nextShape);

        this.gridElement = document.querySelector('.grid');
        document.addEventListener("keydown", (event) => {
            this.handleKeyDown(event);
        });

        this.linesElement = document.getElementById('lines');
        const pauseButton = document.getElementById("pause-button");
        const resumeButton = document.getElementById('resume-button');
        const restartButton = document.getElementById("restart-button");
        const howToPlayButton = document.getElementById("how-to-play-button");
        const backButton = document.getElementById("back-button");

        restartButton.addEventListener('click', this.startNewGame);

        this.hidePauseScreen();
        pauseButton.addEventListener('click', () => {
            if (!this.gameOver) {
                if (!this.paused) {
                    this.paused = true;
                    this.timer.stop();
                    this.showPauseScreen();
                } else {
                    return
                }
            }
        });

        resumeButton.addEventListener('click', () => {
            this.paused = false;
            this.timer.start();
            this.hidePauseScreen();
        });

        howToPlayButton.addEventListener('click', () => {
            this.showHowToPlayScreen();
            this.disableSpaceBar();
        });

        backButton.addEventListener('click', () => {
            this.hideHowToPlayScreen();
            this.enableSpaceBar();
        });
        this.timer.start();
        this.updateLoop();
    }

    moveBlockDown() {
        if (this.gameOver) {
            return;
        }
        this.map.clearBlock(this.bloccoCorrente);

        this.bloccoCorrente.moveDown();

        if (this.bloccoCorrente.checkCollision(this.map)) {
            this.bloccoCorrente.moveUp();
            this.bloccoCorrente.settle(this.map);
            if (this.isGameOver()) {
                this.showGameOverScreen();
                this.endGame();
                return;
            }
        }
        this.map.drawBlock(this.bloccoCorrente);
        this.map.updateGrid();
    }

    disableSpaceBar() {
        this.spaceBarEnabled = false;
    }

    enableSpaceBar() {
        this.spaceBarEnabled = true;
    }

    handleKeyDown(event) {

        if (event.code === "Space" && this.spaceBarEnabled) {
            event.preventDefault();
            if (this.gameOver) {
                this.startNewGame();
            } else {
                if (!this.paused) {
                    this.paused = true;
                    this.timer.stop();
                    this.showPauseScreen();
                } else {
                    this.paused = false;
                    this.timer.start();
                    this.hidePauseScreen();
                }
            }
            return;
        }

        if (this.gameOver || this.paused) {
            return;
        }

        const prevX = this.bloccoCorrente.x;
        const prevY = this.bloccoCorrente.y;
        this.map.clearBlock(this.bloccoCorrente);

        switch (event.key) {
            case "ArrowLeft":
                this.bloccoCorrente.moveLeft();
                break;
            case "ArrowRight":
                this.bloccoCorrente.moveRight();
                break;
            case "ArrowDown":
                event.preventDefault();
                this.moveBlockDown();
                if (!this.gameOver) {
                    this.score += 1;
                    this.updateScore(this.score);
                }
                return;
            case "ArrowUp":
                event.preventDefault();
                this.bloccoCorrente.rotate();
                break;
        }

        if (this.bloccoCorrente.checkCollision(this.map)) {
            this.bloccoCorrente.x = prevX;
            this.bloccoCorrente.y = prevY;
        } else {
            this.map.drawBlock(this.bloccoCorrente);
            this.map.updateGrid();
        }
    }

    // FUNZIONI DI AGGIORNAMENTO

    increaseCompletedRows(rows) {
        this.completedRows += rows;

        const scoringTable = [0, 40, 100, 300, 1200];
        this.score += scoringTable[rows] * (this.level);
        this.updateScore(this.score);
        const newLevel = Math.floor(this.completedRows / 10) + 1;
        if (newLevel > this.level) {
            this.level = newLevel;
            this.updateLevel(this.level);
            this.updateFallInterval();
        }
        this.linesElement.textContent = this.completedRows;
    }

    updateFallInterval() {
        const newFallInterval = this.fallInterval * 0.85;
        this.fallInterval = newFallInterval;
        this.timer.stop();
        this.timer.start();
    }

    updateScore(score) {
        this.score = score;
        const scoreElement = document.getElementById("score");
        scoreElement.textContent = this.score;
    }

    updateLevel(level) {
        this.level = level;
        const levelElement = document.getElementById("level");
        levelElement.textContent = this.level;
    }

    drawNextPiece(nextShape) {
        const nextPieceGrid = document.getElementById("next-piece-grid");
        nextPieceGrid.innerHTML = "";

        for (let row = 0; row < nextShape.length; row++) {
            const rowElement = document.createElement("div");
            rowElement.className = "next-piece-row";

            for (let col = nextShape[row].length - 1; col >= 0; col--) {
                const cellElement = document.createElement("div");
                cellElement.className = nextShape[row][col] === 1 ? "cell block" : "cell";
                rowElement.appendChild(cellElement);
            }

            nextPieceGrid.appendChild(rowElement);
        }
    }

    //PAUSE FUNCTIONS

    showPauseScreen() {
        const pauseScreen = document.getElementById("pause-screen");
        pauseScreen.style.display = "block";
    }

    hidePauseScreen() {
        const pauseScreen = document.getElementById("pause-screen");
        pauseScreen.style.display = "none";
    }

    showHowToPlayScreen() {
        const howToPlayScreen = document.getElementById("how-to-play-screen");
        howToPlayScreen.style.display = "block";
    }

    hideHowToPlayScreen() {
        const howToPlayScreen = document.getElementById("how-to-play-screen");
        howToPlayScreen.style.display = "none";
    }

    //      MONEY FUNCTIONS

    calcolaRicompensa(punteggio) {
        return Math.floor(punteggio / 100);
    }

    //      GAMEOVER FUNCTIONS

    startNewGame() {
        const gameOverScreen = document.getElementById("game-over-screen");
        gameOverScreen.style.display = "none";

        window.location.reload();
    }

    showGameOverScreen() {
        const gameOverScreen = document.getElementById("game-over-screen");
        const scoreValue = document.getElementById("score-value");
        scoreValue.textContent = this.score;
        const linesValue = document.getElementById("lines-value");
        linesValue.textContent = this.completedRows;
        gameOverScreen.style.display = "block";
    }

    isGameOver() {
        for (let col = 0; col < this.map.width; col++) {
            if (this.map.grid[0][col] === 1) {
                return true;
            }
        }
        return false;
    }

    endGame() {
        this.gameOver = true;
        this.timer.stop();
        const ricompensa = this.calcolaRicompensa(this.score);
        aggiornaHighscore(this.score, this.completedRows, this.level);
        aggiornaSaldo(ricompensa);
    }

    //      ANIMATION FUNCTIONS

    update(timestamp) {
        const deltaTime = timestamp - this.lastUpdateTime;

        if (deltaTime > this.fallInterval) {
            this.lastUpdateTime = timestamp;

        }
    }

    updateLoop(timestamp) {
        this.update(timestamp);
        requestAnimationFrame(this.updateLoop.bind(this));
    }

}


