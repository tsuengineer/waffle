class Edit {
    BLACK_TURN = 100;
    WHITE_TURN = -100;
    initTurn;
    nowTurn;
    playerBoard;
    opponentBoard;
    inputBoard;
    currentKifu;
    currentMoveCount;
    moveTotalCount;
    undoStack;
    redoStack;

    /**
     * コンストラクタ
     * @param {string} inputBoard 初期盤面
     * @param {string} [turn='black'] 初期手番
     */
    constructor(inputBoard, turn= 'black') {
        this.initTurn = turn === 'white' ? this.WHITE_TURN : this.BLACK_TURN;
        this.inputBoard = inputBoard;
        this.initBoard(this.inputBoard);
        this.moveTotalCount = 0;
        this.currentMoveCount = 0;
        this.currentKifu = '';
        this.undoStack = [];
        this.redoStack = [];
    }

    /**
     * 初期盤面を設定する
     * @param {string} inputBoard 初期盤面
     */
    initBoard(inputBoard) {
        this.nowTurn = this.initTurn;
        this.currentKifu = '';

        if (inputBoard !== '') {
            let black = 0n;
            let white = 0n;
            let index = 0;
            for (let i = 0; i < 8; i++) {
                for (let j = 0; j < 8; j++) {
                    const char = inputBoard.charAt(index++);
                    const bitPosition = (7 - i) * 8 + (7 - j);
                    if (char === "X") {
                        black |= 1n << BigInt(bitPosition);
                    } else if (char === "O") {
                        white |= 1n << BigInt(bitPosition);
                    }
                }
            }

            this.playerBoard = black;
            this.opponentBoard = white;
        } else {
            // 一般的な初期配置を指定
            this.playerBoard = 0x0000000810000000n;
            this.opponentBoard = 0x0000001008000000n;
        }
    }

    /**
     * 指定した方向に対して合法手をチェックする
     * @param {BigInt} watchBoard チェックする盤面
     * @param {function} shiftFunc ビットシフト関数
     * @param {function} reverseShiftFunc 逆ビットシフト関数
     * @return {BigInt} 合法手
     */
    checkDirection(watchBoard, shiftFunc, reverseShiftFunc) {
        let tmp = watchBoard & shiftFunc(this.playerBoard);
        tmp |= watchBoard & shiftFunc(tmp);
        tmp |= watchBoard & shiftFunc(tmp);
        tmp |= watchBoard & shiftFunc(tmp);
        tmp |= watchBoard & shiftFunc(tmp);
        tmp |= watchBoard & shiftFunc(tmp);

        return reverseShiftFunc(tmp);
    }

    /**
     * 合法手を作成する
     * @return {BigInt} 合法手の盤面
     */
    makeLegalBoard() {
        const horizontalWatchBoard = this.opponentBoard & BigInt("0x7e7e7e7e7e7e7e7e");
        const verticalWatchBoard = this.opponentBoard & BigInt("0x00FFFFFFFFFFFF00");
        const allSideWatchBoard = this.opponentBoard & BigInt("0x007e7e7e7e7e7e00");
        const blankBoard = ~(this.playerBoard | this.opponentBoard);

        let legalBoard = BigInt(0);

        // 左 右 上 下 右斜め上 左斜め上 右斜め下 左斜め下
        legalBoard |= blankBoard & this.checkDirection(horizontalWatchBoard,
            board => board << 1n, board => board << 1n);
        legalBoard |= blankBoard & this.checkDirection(horizontalWatchBoard,
            board => board >> 1n, board => board >> 1n);
        legalBoard |= blankBoard & this.checkDirection(verticalWatchBoard,
            board => board << 8n, board => board << 8n);
        legalBoard |= blankBoard & this.checkDirection(verticalWatchBoard,
            board => board >> 8n, board => board >> 8n);
        legalBoard |= blankBoard & this.checkDirection(allSideWatchBoard,
            board => board << 7n, board => board << 7n);
        legalBoard |= blankBoard & this.checkDirection(allSideWatchBoard,
            board => board << 9n, board => board << 9n);
        legalBoard |= blankBoard & this.checkDirection(allSideWatchBoard,
            board => board >> 9n, board => board >> 9n);
        legalBoard |= blankBoard & this.checkDirection(allSideWatchBoard,
            board => board >> 7n, board => board >> 7n);

        return legalBoard;
    }

    /**
     * 指定した位置に石を置けるかチェックする
     * @param {bigint} put 石を置く位置
     * @return {boolean} 石を置けるか
     */
    canPut(put) {
        const legalBoard = this.makeLegalBoard();
        return (BigInt(put) & legalBoard) === BigInt(put);
    }

    /**
     * 着手し,反転処理を行う
     * @param put 着手した場所のみにフラグが立つ64ビット
     */
    reverse(put) {
        let rev = BigInt(0);
        for (let k = 0; k < 8; k++) {
            let rev_ = BigInt(0);
            let mask = this.transfer(put, k);
            while ((mask !== BigInt(0)) && ((mask & this.opponentBoard) !== BigInt(0))) {
                rev_ |= mask;
                mask = this.transfer(mask, k);
            }
            if ((mask & this.playerBoard) !== BigInt(0)) {
                rev |= rev_;
            }
        }
        this.playerBoard ^= put | rev;
        this.opponentBoard ^= rev;
    }

    /**
     * 手番の入れ替え
     */
    swapBoard() {
        [this.playerBoard, this.opponentBoard] = [this.opponentBoard, this.playerBoard];
        this.nowTurn *= -1;
    }

    /**
     * 反転箇所を求める
     * @param put 着手した場所のみにフラグが立つ64ビット
     * @param k   反転方向(8つ)
     * @return bigint
     */
    transfer(put, k) {
        const masks = [
            0xffffffffffffff00n, // 上
            0x7f7f7f7f7f7f7f00n, // 右上
            0x7f7f7f7f7f7f7f7fn, // 右
            0x007f7f7f7f7f7f7fn, // 右下
            0x00ffffffffffffffn, // 下
            0x00fefefefefefefen, // 左下
            0xfefefefefefefefen, // 左
            0xfefefefefefefe00n  // 左上
        ];
        const shifts = [8n, 7n, -1n, -9n, -8n, -7n, 1n, 9n];

        if (k < 0 || k > 7) return 0n;

        const shift = shifts[k];
        return shift > 0n ? (put << shift) & masks[k] : (put >> -shift) & masks[k];
    }

    /**
     * 座標をbitに変換する
     * @param x 横座標(A~H)
     * @param y 縦座標(1~8)
     * @return bigint
     */
    coordinateToBit(x, y) {
        const xOffset = x.charCodeAt(0) - 'A'.charCodeAt(0);
        const yOffset = BigInt(y - 1);
        return BigInt("0x8000000000000000") >> (yOffset * 8n + BigInt(xOffset));
    }

    /**
     * SVG要素を作成する
     * @param {string} type 要素のタイプ
     * @param {Object} [attributes={}] 属性
     * @return {Element} 作成したSVG要素
     */
    createSvgElement(type, attributes = {}) {
        const element = document.createElementNS("http://www.w3.org/2000/svg", type);
        for (const [key, value] of Object.entries(attributes)) {
            element.setAttribute(key, value);
        }
        return element;
    }

    /**
     * 盤面を描画する
     * @param {string} lastMove 最後の手
     */
    drawBoard(lastMove) {
        const boardDiv = document.getElementById("editBoard");
        const frameHeight = 820;
        const boardFrameSize = 670;
        const boardSize = 576;
        const cellSize = 72;
        const labelSize = 20;
        const labelFontSize = 28;
        const boardPadding = (boardFrameSize - boardSize) / 2 + labelSize;

        if (this.currentKifu) {
            lastMove = this.currentMoveCount > 0
                ? this.currentKifu.substr((this.currentMoveCount - 1) * 2, 2)
                : "--";
        }

        const bitLastMove = lastMove && lastMove !== '--'
            ? this.coordinateToBit(lastMove.substring(0, 1), lastMove.substring(1))
            : BigInt(0);

        // 既存のSVGが存在する場合、削除する
        if (boardDiv.firstChild) {
            boardDiv.removeChild(boardDiv.firstChild);
        }

        // 新しいSVGを追加する
        const boardSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        boardSvg.setAttribute("viewBox", "0 0 " + boardFrameSize + " " + frameHeight);

        // オセロ盤を描画する
        const rect = this.createSvgElement("rect", {
            x: "0",
            y: "0",
            width: `${boardFrameSize}`,
            height: `${boardFrameSize}`,
            fill: "#3fb8dd",
            rx: "8",
        });
        boardSvg.appendChild(rect);

        // オセロ盤の線を描画する
        for (let i = 0; i <= 8; i++) {
            const vLine = this.createSvgElement("line", {
                x1: `${i * cellSize + boardPadding}`,
                y1: `${boardPadding}`,
                x2: `${i * cellSize + boardPadding}`,
                y2: `${boardPadding + boardSize}`,
                stroke: "#333366",
                "stroke-width": "1",
            });
            boardSvg.appendChild(vLine);

            const hLine = this.createSvgElement("line", {
                x1: `${boardPadding}`,
                y1: `${i * cellSize + boardPadding}`,
                x2: `${boardPadding + boardSize}`,
                y2: `${i * cellSize + boardPadding}`,
                stroke: "#333366",
                "stroke-width": "1",
            });
            boardSvg.appendChild(hLine);
        }

        // 星を描画する
        for (let i = 0; i < 2; i++) {
            for (let j = 0; j < 2; j++) {
                const cell = this.createSvgElement("circle", {
                    cx: String(cellSize * 3 + i * cellSize * 4 - 5),
                    cy: String(cellSize * 3 + j * cellSize * 4 - 5),
                    fill: "#333366",
                    r: "4",
                });
                boardSvg.appendChild(cell);
            }
        }

        // 座標のラベルを描画する
        const labels = 'ABCDEFGH';
        for (let i = 0; i < 8; i++) {
            const hText = this.createSvgElement("text", {
                x: `${cellSize * (i + 1) + ((cellSize - labelFontSize) / 2)}`,
                y: `${labelSize + labelSize}`,
                fill: "#333366",
                "font-size": `${labelFontSize}`,
            });
            hText.textContent = labels[i];
            boardSvg.appendChild(hText);

            const vText = this.createSvgElement("text", {
                x: `${labelSize}`,
                y: `${cellSize * (i + 1) + ((cellSize - labelFontSize) / 2) + labelSize}`,
                fill: "#333366",
                "font-size": `${labelFontSize}`,
            });
            vText.textContent = `${i + 1}`;
            boardSvg.appendChild(vText);
        }

        // 盤面の描画
        let count = 1;
        for (let i = 8; i > 0; i--) {
            for (let j = 8; j > 0; j--) {
                const cell = this.createSvgElement("circle", {
                    cy: String((i - 0.5) * cellSize + boardPadding),
                    cx: String((j - 0.5) * cellSize + boardPadding),
                    r: "28",
                    fill: this.determineFillColor(this.playerBoard, this.opponentBoard, this.nowTurn, count),
                });
                boardSvg.appendChild(cell);

                // 最終手にマーク
                if (Number(bitLastMove.toString(2)[bitLastMove.toString(2).length - count])) {
                    const marker = this.createSvgElement("rect", {
                        y: String((i - 0.5) * cellSize + boardPadding - 4),
                        x: String((j - 0.5) * cellSize + boardPadding - 4),
                        fill: "red",
                        width: "8",
                        height: "8",
                    });
                    boardSvg.appendChild(marker);
                }

                count++;
            }
        }

        // クリックイベントリスナーを追加
        boardSvg.addEventListener("click", (event) => {
            const rect = boardSvg.getBoundingClientRect();
            const scaleX = boardSvg.viewBox.baseVal.width / rect.width;
            const scaleY = boardSvg.viewBox.baseVal.height / rect.height;

            const x = (event.clientX - rect.left) * scaleX - boardPadding;
            const y = (event.clientY - rect.top) * scaleY - boardPadding;

            const col = Math.floor(x / cellSize);
            const row = Math.floor(y / cellSize);

            if (col >= 0 && col < 8 && row >= 0 && row < 8) {
                const colText = ["A", "B", "C", "D", "E", "F", "G", "H"];
                const rowText = ["1", "2", "3", "4", "5", "6", "7", "8"];
                const put = this.coordinateToBit(colText[col], rowText[row]);

                const nowKifu = colText[col] + rowText[row]
                this.currentKifu = this.currentKifu.substr(0, this.currentMoveCount * 2) + nowKifu;

                if (this.canPut(put)) {
                    this.redoStack = [];
                    this.currentMoveCount++;

                    // 現在の手数以降のスタックを削除してから最終手の盤面を保存
                    this.undoStack.push({
                        nowTurn: this.nowTurn,
                        playerBoard: this.playerBoard,
                        opponentBoard: this.opponentBoard,
                        kifu: this.currentKifu,
                    });

                    this.reverse(put);
                    this.swapBoard();
                    this.drawBoard(nowKifu);
                } else {
                    const legalMoves = this.makeLegalBoard();
                    if (legalMoves === 0n) {
                        this.swapBoard();
                        if (this.makeLegalBoard() === 0n) {
                            // 終局
                        }
                        if (this.canPut(put)) {
                            this.redoStack = [];
                            this.currentMoveCount++;
                            this.reverse(put);
                            this.swapBoard();
                            this.drawBoard(nowKifu);
                        }
                    }
                }
            }
        });
        boardDiv.appendChild(boardSvg);

        // 情報パネル
        const infoRect = this.createSvgElement("rect", {
            x: '0',
            y: String(boardFrameSize + 5),
            width: String(boardFrameSize),
            height: "60",
            fill: "#aaa",
        });
        boardSvg.appendChild(infoRect);

        for (let i = 0; i < 2; i++) {
            const cell = this.createSvgElement("circle", {
                cx: String(100 * i + 80),
                cy: "705",
                fill: i === 0 ? "#333" : "#fff",
                r: "20",
            });
            boardSvg.appendChild(cell);

            const turnMarker = this.createSvgElement("circle", {
                cx: String(100 * i + 40),
                cy: "705",
                fill: i === 0 && this.nowTurn === this.BLACK_TURN || i === 1 && this.nowTurn === this.WHITE_TURN ? "#fefd68" : "#ccc",
                r: "8",
            });
            boardSvg.appendChild(turnMarker);

            const text = this.createSvgElement("text", {
                x: String(100 * i + 80),
                y: "712",
                "text-anchor": "middle",
                fill: i === 0 ? "#fff" : "#333",
                "font-size": "22",
            });
            if (this.nowTurn === this.BLACK_TURN) {
                text.textContent = `${i === 0 ? this.bitCount(this.playerBoard) : this.bitCount(this.opponentBoard)}`;
            } else {
                text.textContent = `${i === 0 ? this.bitCount(this.opponentBoard) : this.bitCount(this.playerBoard)}`;
            }
            boardSvg.appendChild(text);
        }

        // 手数
        const moveCountText = this.createSvgElement("text", {
            x: "350",
            y: "712",
            "text-anchor": "middle",
            fill: "#333",
            "font-size": "22",
        });
        moveCountText.textContent = this.currentMoveCount + ':';
        boardSvg.appendChild(moveCountText);

        // 最終手の座標
        const moveText = this.createSvgElement("text", {
            x: "400",
            y: "712",
            "text-anchor": "middle",
            fill: "#333",
            "font-size": "22",
        });
        moveText.textContent = lastMove ? lastMove : '--';
        boardSvg.appendChild(moveText);

        const commentText1 = this.createSvgElement("text", {
            x: "0",
            y: "760",
            "text-anchor": "left",
            fill: "#fff",
            "font-size": "18",
        });

        commentText1.textContent = '盤面をクリックすると、ここに棋譜が表示されるのでコピーしてお使いください';
        boardSvg.appendChild(commentText1);
        const commentText2 = this.createSvgElement("text", {
            x: "0",
            y: "790",
            "text-anchor": "left",
            fill: "#fff",
            "font-size": "9",
        });

        commentText2.textContent = this.currentKifu.substr(0, this.currentMoveCount * 2);
        boardSvg.appendChild(commentText2);

        boardDiv.appendChild(boardSvg);
    }

    /**
     * 石の色を決定する
     * @param {BigInt} playerBoard プレイヤーの盤面
     * @param {BigInt} opponentBoard 対戦相手の盤面
     * @param {number} nowTurn 現在の手番
     * @param {number} count カウント
     * @return {string} 石の色
     */
    determineFillColor(playerBoard, opponentBoard, nowTurn, count) {
        const playerBoardBinary = playerBoard.toString(2).padStart(64, '0');
        const opponentBoardBinary = opponentBoard.toString(2).padStart(64, '0');
        const isPlayerStone = Number(playerBoardBinary[playerBoardBinary.length - count]);
        const isOpponentStone = Number(opponentBoardBinary[opponentBoardBinary.length - count]);

        if (isPlayerStone) {
            return nowTurn === this.BLACK_TURN ? "black" : "white";
        } else if (isOpponentStone) {
            return nowTurn === this.BLACK_TURN ? "white" : "black";
        } else {
            return "#3fb8dd";
        }
    }

    /**
     * ビットカウント
     * @param num: UINT64
     * @return 立ってるフラグの数[Int]
     */
    bitCount(num) {
        let mask = BigInt("0x8000000000000000");
        let count = 0;

        for (let i = 0n; i < 64; i++) {
            if (mask & num) {
                count += 1;
            }
            mask >>= 1n;
        }
        return count;
    }

    /**
     * 盤面を作成する
     */
    makeBoard(kifu, loopCount) {
        for (let i = 0; i < loopCount; i++) {
            const x = kifu.substring(i * 2, i * 2 + 1);
            const y = kifu.substring(i * 2 + 1, i * 2 + 2);

            const put = this.coordinateToBit(x, y);

            if (this.canPut(put)) {
                this.reverse(put);
                this.swapBoard();
            } else {
                const legalMoves = this.makeLegalBoard();
                if (legalMoves === 0n) {
                    this.swapBoard();
                    if (this.makeLegalBoard() === 0n) {
                        break;
                    }
                    if (this.canPut(put)) {
                        this.reverse(put);
                        this.swapBoard();
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }
        if (loopCount) {
            this.drawBoard(kifu.substr((loopCount - 1) * 2, 2));
        } else {
            this.drawBoard('');
        }
    }

    /**
     * 前の手に戻る
     */
    movePrev() {
        if (this.undoStack.length > 0) {
            const previousState = this.undoStack.pop();
            this.redoStack.push({
                nowTurn: this.nowTurn,
                playerBoard: this.playerBoard,
                opponentBoard: this.opponentBoard,
                kifu: this.currentKifu,
            });
            this.currentMoveCount--;
            this.playerBoard = previousState.playerBoard;
            this.opponentBoard = previousState.opponentBoard;
            this.nowTurn = previousState.nowTurn;
            this.currentKifu = previousState.kifu;
            this.makeBoard(this.currentKifu, this.currentMoveCount);
            this.drawBoard();
        }
    }

    /**
     * 次の手に進む
     */
    moveNext() {
        if (this.redoStack.length > 0) {
            const nextState = this.redoStack.pop();
            this.undoStack.push({
                nowTurn: this.nowTurn,
                playerBoard: this.playerBoard,
                opponentBoard: this.opponentBoard,
                kifu: this.currentKifu,
            });
            this.currentMoveCount++;
            this.playerBoard = nextState.playerBoard;
            this.opponentBoard = nextState.opponentBoard;
            this.nowTurn = nextState.nowTurn;
            this.currentKifu = nextState.kifu;
            this.makeBoard(this.currentKifu, this.currentMoveCount);
            this.drawBoard();
        }
    }
}
