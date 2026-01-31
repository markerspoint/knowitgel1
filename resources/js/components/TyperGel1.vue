<template>
    <div
        class="min-h-screen bg-[#050505] text-white relative overflow-hidden font-sans selection:bg-red-500/30"
    >
        <!-- Technical Grid Background -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-size-[50px_50px]"
            ></div>
            <div
                class="absolute inset-0 bg-radial-at-t from-red-500/10 via-transparent to-transparent"
            ></div>
        </div>

        <!-- Scanline Overlay -->
        <div
            class="absolute inset-0 pointer-events-none z-50 opacity-[0.03] bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-size-[100%_2px,3px_100%]"
        ></div>

        <div class="relative z-20 flex flex-col h-screen">
            <!-- Header/Nav -->
            <nav
                class="flex items-center justify-between px-8 py-5 bg-black/60 backdrop-blur-xl border-b border-white/5 relative overflow-hidden"
            >
                <div
                    class="absolute bottom-0 left-0 h-px bg-red-500/50 w-full shadow-[0_0_15px_rgba(239,68,68,0.5)]"
                ></div>

                <div class="flex items-center space-x-4">
                    <div
                        class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center"
                    >
                        <i
                            class="fas fa-keyboard text-red-500 animate-pulse"
                        ></i>
                    </div>
                    <div>
                        <span
                            class="block text-sm font-black uppercase tracking-[0.2em] text-white"
                            >Neural Input Interface</span
                        >
                        <span
                            class="block text-[9px] font-mono text-gray-500 uppercase tracking-widest"
                            >Protocol: Buffer Stream Processing</span
                        >
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex flex-col items-end">
                        <span
                            class="text-[9px] font-mono text-gray-500 uppercase tracking-widest leading-none"
                            >Matrix Sync Status</span
                        >
                        <span
                            class="text-xs font-black text-red-500 uppercase tracking-tighter"
                            >{{ difficulty }} STABILITY</span
                        >
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            @click="resetGame"
                            class="px-5 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white text-[10px] font-black uppercase tracking-widest border border-white/10 transition-all"
                        >
                            Reset
                        </button>
                        <button
                            @click="$router.push('/user/dashboard')"
                            class="px-5 py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-500 text-[10px] font-black uppercase tracking-widest border border-red-500/20 transition-all"
                        >
                            Abort
                        </button>
                    </div>
                </div>
            </nav>

            <div class="flex-1 relative overflow-hidden">
                <!-- Word Packets Container (High Index) -->
                <div class="absolute inset-0 z-50">
                    <div
                        v-for="bubble in activeBubbles"
                        :key="bubble.id"
                        class="absolute flex flex-col items-center justify-center p-6 transition-all duration-300 select-none"
                        :class="[
                            bubble.isCompleted ? 'scale-0 opacity-0' : '',
                            bubble.showIncorrect ? 'shake-anim' : '',
                        ]"
                        :style="{
                            left: bubble.x + '%',
                            top: bubble.y + '%',
                            transform: 'translate(-50%, -50%)',
                            minWidth: '160px',
                            maxWidth: '260px',
                        }"
                    >
                        <div
                            class="absolute inset-0 rounded-xl border backdrop-blur-xl transition-all duration-300 shadow-xl"
                            :class="[
                                bubble.id === focusedBubbleId
                                    ? 'bg-red-500/10 border-red-500/60 shadow-[0_0_20px_rgba(239,68,68,0.2)]'
                                    : 'bg-black/80 border-white/10',
                            ]"
                        ></div>
                        <div
                            class="absolute -top-1 -left-1 w-2 h-2 border-t border-l border-red-500/20"
                            :class="
                                bubble.id === focusedBubbleId
                                    ? 'border-red-500'
                                    : ''
                            "
                        ></div>
                        <div
                            class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-red-500/20"
                            :class="
                                bubble.id === focusedBubbleId
                                    ? 'border-red-500'
                                    : ''
                            "
                        ></div>

                        <div class="relative z-10 text-center py-2 px-3">
                            <span
                                class="block text-[7px] font-mono text-gray-500 uppercase tracking-[0.3em] mb-1"
                                >Encrypted Packet</span
                            >
                            <div
                                class="flex items-center justify-center font-black text-lg uppercase tracking-[0.2em]"
                            >
                                <span
                                    v-for="(char, index) in bubble.text.split(
                                        '',
                                    )"
                                    :key="index"
                                    :class="
                                        index < bubble.progress
                                            ? 'text-red-500 drop-shadow-[0_0_8px_#ef4444]'
                                            : 'text-white'
                                    "
                                >
                                    {{ char }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats HUD (Shifted to Left, Lower Index) -->
                <div class="absolute top-8 left-10 max-w-sm w-full z-40">
                    <div
                        class="bg-black/70 backdrop-blur-3xl border border-white/10 rounded-2xl p-6 shadow-2xl relative overflow-hidden"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse shadow-[0_0_8px_#ef4444]"
                                ></span>
                                <span
                                    class="text-[8px] font-black text-white uppercase tracking-[0.2em]"
                                    >Stream Telemetry</span
                                >
                            </div>
                            <div class="flex items-center space-x-4">
                                <span
                                    class="text-[8px] font-mono text-gray-500 uppercase"
                                    >T-{{ remainingTime.toFixed(1) }}s</span
                                >
                                <span
                                    class="px-2 py-0.5 bg-red-500/10 border border-red-500/20 rounded text-[8px] font-mono text-red-500 font-bold"
                                    >WPM: {{ wpm.toFixed(1) }}</span
                                >
                            </div>
                        </div>
                        <div
                            class="w-full h-[1.5px] bg-white/5 rounded-full overflow-hidden mb-3"
                        >
                            <div
                                class="h-full bg-red-500 shadow-[0_0_10px_#ef4444]"
                                :style="{ width: timerBarWidth + '%' }"
                            ></div>
                        </div>
                        <p
                            class="text-[10px] text-center text-gray-400 uppercase tracking-widest font-medium italic"
                        >
                            Clear word packets before buffer overflow. Sync:
                            {{ (accuracy * 100).toFixed(0) }}%
                        </p>
                    </div>
                </div>

                <!-- Desktop/Keyboard Console -->
                <div
                    class="absolute bottom-[-20px] left-0 w-full h-[300px] pointer-events-none z-30"
                >
                    <div
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[750px] h-full flex flex-col items-center justify-end pb-8"
                    >
                        <!-- Technical Base Plate -->
                        <div
                            class="absolute bottom-0 w-full h-28 bg-[#0a0a0a] rounded-t-[4rem] border-t border-red-500/20 shadow-[0_-20px_60px_rgba(0,0,0,1)]"
                        >
                            <div
                                class="absolute top-0 left-0 w-full h-px bg-red-500/30 animate-pulse"
                            ></div>
                        </div>

                        <!-- Interface Row (Hands + Keyboard + Character) -->
                        <div
                            class="relative w-full flex items-end justify-center space-x-16 z-10 px-10"
                        >
                            <!-- Character Node -->
                            <div
                                class="w-24 h-24 rounded-4xl bg-gradient-to-br from-red-500/10 to-black border border-red-500/30 flex items-center justify-center relative shadow-2xl shrink-0 mb-2"
                                ref="characterHead"
                            >
                                <div
                                    class="w-16 h-16 rounded-full bg-black border border-red-500/20 flex items-center justify-center overflow-hidden"
                                >
                                    <div
                                        class="w-12 h-1 bg-red-500 animate-pulse shadow-[0_0_10px_#ef4444]"
                                    ></div>
                                </div>
                            </div>

                            <!-- Typing Mechanism -->
                            <div class="relative w-[420px] shrink-0">
                                <!-- Keyboard Perspective Wrapper -->
                                <div
                                    class="relative perspective-[1000px] transform-style-preserve-3d pb-2"
                                >
                                    <div
                                        class="hands-container absolute -top-16 left-0 w-full h-24 z-20 pointer-events-none"
                                    >
                                        <div
                                            class="hand-left-wrapper absolute left-10"
                                            ref="handLeft"
                                        >
                                            <div
                                                class="hand-realistic hand-left opacity-30 invert"
                                            >
                                                <div class="wrist"></div>
                                                <div class="palm"></div>
                                                <div class="fingers">
                                                    <div
                                                        v-for="i in 4"
                                                        class="finger"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="hand-right-wrapper absolute right-10"
                                            ref="handRight"
                                        >
                                            <div
                                                class="hand-realistic hand-right opacity-30 invert"
                                            >
                                                <div class="wrist"></div>
                                                <div class="palm"></div>
                                                <div class="fingers">
                                                    <div
                                                        v-for="i in 4"
                                                        class="finger"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="keyboard-base-container transform rotateX-20 scale-95 origin-bottom"
                                    >
                                        <div
                                            class="bg-[#111] border border-red-500/20 rounded-xl p-3 shadow-inner space-y-2"
                                        >
                                            <div
                                                v-for="r in 3"
                                                :key="r"
                                                class="flex justify-center space-x-1"
                                            >
                                                <div
                                                    v-for="i in 10"
                                                    :key="i"
                                                    class="w-8 h-8 rounded-lg bg-zinc-900 border border-white/5 relative overflow-hidden transition-all duration-75"
                                                    :class="
                                                        pressedKeyIndex ===
                                                        (r - 1) * 10 + i - 1
                                                            ? 'scale-90 border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.8)]'
                                                            : ''
                                                    "
                                                >
                                                    <div
                                                        class="absolute inset-0 bg-red-500 transition-opacity duration-75"
                                                        :class="
                                                            pressedKeyIndex ===
                                                            (r - 1) * 10 + i - 1
                                                                ? 'opacity-100'
                                                                : 'opacity-0'
                                                        "
                                                    ></div>
                                                    <div
                                                        class="absolute inset-x-1 bottom-1 h-0.5 bg-white/40 rounded-full transition-opacity duration-75"
                                                        :class="
                                                            pressedKeyIndex ===
                                                            (r - 1) * 10 + i - 1
                                                                ? 'opacity-100'
                                                                : 'opacity-0'
                                                        "
                                                    ></div>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <div
                                                    class="w-40 h-8 rounded-lg bg-zinc-900 border border-white/5 relative overflow-hidden transition-all duration-75"
                                                    :class="
                                                        pressedKeyIndex === 30
                                                            ? 'scale-95 border-red-500 shadow-[0_0_20px_rgba(239,68,68,0.8)]'
                                                            : ''
                                                    "
                                                >
                                                    <div
                                                        class="absolute inset-0 bg-red-500 transition-opacity duration-75"
                                                        :class="
                                                            pressedKeyIndex ===
                                                            30
                                                                ? 'opacity-100'
                                                                : 'opacity-0'
                                                        "
                                                    ></div>
                                                    <div
                                                        class="absolute inset-x-4 bottom-1 h-0.5 bg-white/40 rounded-full transition-opacity duration-75"
                                                        :class="
                                                            pressedKeyIndex ===
                                                            30
                                                                ? 'opacity-100'
                                                                : 'opacity-0'
                                                        "
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Idle/Start/Finish Logic remains same -->
                <transition name="fade"
                    ><div
                        v-if="phase === 'idle' || phase === 'loading'"
                        class="absolute inset-0 flex flex-col items-center justify-center bg-black/90 backdrop-blur-xl z-[200]"
                    >
                        <div class="max-w-xl w-full p-12 text-center relative">
                            <div
                                class="absolute -top-10 left-1/2 -translate-x-1/2 text-red-500/5 text-[180px] font-black -z-10 rotate-12 select-none uppercase"
                            >
                                Type
                            </div>
                            <div
                                class="w-24 h-24 bg-red-500/10 rounded-3xl border border-red-500/30 flex items-center justify-center mx-auto mb-10 transform -rotate-12 group"
                            >
                                <i
                                    class="fas fa-keyboard text-4xl text-red-500 group-hover:scale-110 transition-transform"
                                ></i>
                            </div>
                            <h2
                                class="text-4xl font-black text-white uppercase tracking-tighter mb-4 italic"
                            >
                                Neural Buffer Link
                            </h2>
                            <p
                                class="text-sm text-gray-400 mb-12 font-medium leading-relaxed uppercase tracking-widest"
                            >
                                Process the IT data stream. Clear encryption
                                packets before buffer overflow occurs.
                            </p>
                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8"
                            >
                                <button
                                    v-for="lvl in ['easy', 'medium', 'hard']"
                                    :key="lvl"
                                    class="group relative px-6 py-10 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/50 hover:bg-red-500/5 transition-all"
                                    @click="startWithDifficulty(lvl)"
                                >
                                    <span
                                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-1 group-hover:text-red-500"
                                        >{{ lvl }} Matrix</span
                                    ><span
                                        class="block text-2xl font-black text-white group-hover:scale-105 transition-transform uppercase"
                                        >{{ lvl }}</span
                                    >
                                </button>
                            </div>
                        </div>
                    </div></transition
                >
                <transition name="fade"
                    ><div
                        v-if="phase === 'finished'"
                        class="absolute inset-0 flex flex-col items-center justify-center bg-[#050505] backdrop-blur-2xl z-200"
                    >
                        <div class="max-w-2xl w-full p-12 text-center">
                            <div
                                :class="[
                                    'w-32 h-32 rounded-4xl border-2 flex items-center justify-center mx-auto mb-8 transition-all',
                                    gameWon
                                        ? 'bg-green-500/10 border-green-500/30 text-green-500'
                                        : 'bg-red-500/10 border-red-500/30 text-red-500',
                                ]"
                            >
                                <i
                                    :class="[
                                        'text-5xl',
                                        gameWon
                                            ? 'fas fa-shield-check'
                                            : 'fas fa-server',
                                    ]"
                                ></i>
                            </div>
                            <h2
                                class="text-5xl font-black text-white uppercase tracking-tighter mb-2 italic"
                            >
                                {{
                                    gameWon
                                        ? "BUFFER FLUSHED"
                                        : "STREAM DEPLETED"
                                }}
                            </h2>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-[0.4em] mb-10"
                            >
                                Data Integrity Output Report
                            </p>
                            <div class="grid grid-cols-3 gap-6 mb-12">
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Throughput (WPM)</span
                                    ><span
                                        class="text-3xl font-black text-white italic"
                                        >{{ wpm.toFixed(0) }}</span
                                    >
                                </div>
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Sync Accuracy</span
                                    ><span
                                        class="text-3xl font-black text-white italic"
                                        >{{
                                            (accuracy * 100).toFixed(0)
                                        }}%</span
                                    >
                                </div>
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Matrix Score</span
                                    ><span
                                        class="text-3xl font-black text-red-500 italic"
                                        >{{ score }}</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-wrap justify-center gap-4">
                                <button
                                    class="px-10 py-4 rounded-xl bg-white text-black font-black uppercase tracking-widest text-[10px] hover:bg-gray-200 transition-all"
                                    @click="resetGame"
                                >
                                    Re-sync Interface</button
                                ><button
                                    class="px-10 py-4 rounded-xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px] hover:bg-red-600 transition-all"
                                    @click="$router.push('/user/dashboard')"
                                >
                                    Exit Terminal
                                </button>
                            </div>
                        </div>
                    </div></transition
                >
            </div>
        </div>
    </div>
</template>

<script>
import { Howl } from "howler";
import { gsap } from "gsap";
import {
    fetchTyperGelConfig,
    submitTyperGelResult,
} from "../services/typerGelApi";

export default {
    name: "TyperGel1",
    data() {
        return {
            difficulty: "easy",
            phase: "idle",
            remainingTime: 0,
            timerId: null,
            backgroundParticles: [],
            activeBubbles: [],
            originalWordPool: [],
            availableWords: [],
            activeWordTexts: new Set(),
            focusedBubbleId: null,
            gameWon: false,
            score: 0,
            correctChars: 0,
            incorrectChars: 0,
            startTime: null,
            endTime: null,
            maxConcurrentBubbles: 3,
            lastSpawnTime: 0,
            correctSound: null,
            wrongSound: null,
            typeSound: null,
            animationFrameId: null,
            errorMessage: "",
            pressedKeyIndex: null,
        };
    },
    computed: {
        timerBarWidth() {
            const base = this.getDifficultyConfig(
                this.difficulty,
            ).durationSeconds;
            return base
                ? Math.max(0, Math.min(100, (this.remainingTime / base) * 100))
                : 0;
        },
        elapsedSeconds() {
            if (!this.startTime) return 0;
            const end = this.endTime || performance.now();
            return (end - this.startTime) / 1000;
        },
        wpm() {
            if (this.elapsedSeconds < 1) return 0; // Safeguard against huge WPM at start
            return this.correctChars / 5 / (this.elapsedSeconds / 60);
        },
        accuracy() {
            const total = this.correctChars + this.incorrectChars;
            return total === 0 ? 1 : this.correctChars / total;
        },
    },
    mounted() {
        this.createBackgroundParticles();
        this.initSounds();
        window.addEventListener("keydown", this.handleKeydown);
        this.startAnimation();
        this.$nextTick(() => {
            this.initCharacterBreathing();
        });
    },
    beforeUnmount() {
        window.removeEventListener("keydown", this.handleKeydown);
        this.clearTimer();
        this.stopAnimation();
        gsap.killTweensOf("*");
    },
    methods: {
        startWithDifficulty(level) {
            this.difficulty = level;
            this.fetchConfigAndStart();
        },
        fetchConfigAndStart() {
            this.phase = "loading";
            fetchTyperGelConfig(this.difficulty)
                .then((res) => {
                    const words = res.data.words || [];
                    this.originalWordPool = words.map((w, i) => ({
                        id: i,
                        text: typeof w === "string" ? w : w.word,
                    }));
                    if (!this.originalWordPool.length) {
                        this.errorMessage = "Handshake Refused.";
                        this.phase = "idle";
                        return;
                    }
                    this.resetStats();
                    this.phase = "active";
                    this.spawnInitialBubbles();
                })
                .catch(() => {
                    this.errorMessage = "Handshake Failure.";
                    this.phase = "idle";
                });
        },
        resetStats() {
            this.activeBubbles = [];
            this.score = 0;
            this.correctChars = 0;
            this.incorrectChars = 0;
            this.startTime = performance.now();
            this.availableWords = [...this.originalWordPool];
            const config = this.getDifficultyConfig(this.difficulty);
            this.maxConcurrentBubbles = config.maxConcurrentBubbles;
            this.remainingTime = config.durationSeconds;
            this.clearTimer();
            this.startTimer();
        },
        spawnInitialBubbles() {
            for (let i = 0; i < 2; i++) this.spawnBubble();
        },
        spawnBubble() {
            const minDistance = 22; // Increased for breathing space
            const candidates = this.availableWords.filter(
                (w) => !this.activeWordTexts.has(w.text),
            );
            if (!candidates.length) return;
            const word =
                candidates[Math.floor(Math.random() * candidates.length)];
            this.activeBubbles.push({
                id: Math.random(),
                text: word.text,
                x: 20 + Math.random() * 60,
                y: -10,
                speed: this.getDifficultyConfig(this.difficulty).bubbleSpeed,
                progress: 0,
                isCompleted: false,
                showIncorrect: false,
            });
            this.activeWordTexts.add(word.text);
        },
        getDifficultyConfig(lvl) {
            if (lvl === "easy")
                return {
                    durationSeconds: 90,
                    bubbleSpeed: 6,
                    bubbleSpawnMs: 2200,
                    maxConcurrentBubbles: 3,
                };
            if (lvl === "medium")
                return {
                    durationSeconds: 75,
                    bubbleSpeed: 9,
                    bubbleSpawnMs: 1800,
                    maxConcurrentBubbles: 4,
                };
            return {
                durationSeconds: 60,
                bubbleSpeed: 13,
                bubbleSpawnMs: 1500,
                maxConcurrentBubbles: 5,
            };
        },
        startTimer() {
            this.timerId = setInterval(() => {
                if (this.phase === "active")
                    this.remainingTime = Math.max(0, this.remainingTime - 0.1);
                if (this.remainingTime <= 0) this.finishGame();
            }, 100);
        },
        clearTimer() {
            if (this.timerId) clearInterval(this.timerId);
        },
        handleKeydown(e) {
            if (this.phase !== "active" || e.metaKey || e.ctrlKey) return;
            if (e.key === "Backspace") {
                this.handleBackspace();
                return;
            }
            if (e.key.length === 1) this.processCharacter(e.key.toLowerCase());
        },
        handleBackspace() {
            if (!this.focusedBubbleId) return;
            const b = this.activeBubbles.find(
                (b) => b.id === this.focusedBubbleId,
            );
            if (b && b.progress > 0) {
                b.progress--;
                this.correctChars--;
            }
        },
        processCharacter(c) {
            const idx = this.getKeyIndex(c);
            this.triggerKeyAnim(idx, null);
            if (this.typeSound) this.typeSound.play();
            if (this.focusedBubbleId) {
                const b = this.activeBubbles.find(
                    (b) => b.id === this.focusedBubbleId,
                );
                if (b) {
                    this.applyToBubble(b, c, idx);
                    return;
                }
            }
            const chosen = this.activeBubbles.find(
                (b) => !b.isCompleted && b.text.charAt(0).toLowerCase() === c,
            );
            if (chosen) {
                this.focusedBubbleId = chosen.id;
                this.applyToBubble(chosen, c, idx);
            } else {
                this.incorrectChars++;
                if (this.wrongSound) this.wrongSound.play();
                this.triggerKeyAnim(idx, false);
            }
        },
        applyToBubble(b, c, idx) {
            if (b.text.charAt(b.progress).toLowerCase() === c) {
                b.progress++;
                this.correctChars++;
                this.score += 10;
                this.triggerKeyAnim(idx, true);
                if (b.progress >= b.text.length) {
                    b.isCompleted = true;
                    this.score += 50;
                    this.focusedBubbleId = null;
                    setTimeout(() => {
                        this.activeBubbles = this.activeBubbles.filter(
                            (x) => x.id !== b.id,
                        );
                        if (this.phase === "active") this.spawnBubble();
                    }, 400);
                }
            } else {
                this.incorrectChars++;
                if (this.wrongSound) this.wrongSound.play();
                b.showIncorrect = true;
                setTimeout(() => (b.showIncorrect = false), 400);
                this.triggerKeyAnim(idx, false);
            }
        },
        triggerKeyAnim(idx, ok) {
            this.pressedKeyIndex = idx;
            const h =
                Math.random() > 0.5
                    ? this.$refs.handLeft
                    : this.$refs.handRight;
            if (h)
                gsap.to(h, { y: -10, duration: 0.05, yoyo: true, repeat: 1 });
            setTimeout(() => (this.pressedKeyIndex = null), 150);
        },
        getKeyIndex(c) {
            const rows = ["qwertyuiop", "asdfghjkl;", "zxcvbnm,./"];
            for (let r = 0; r < 3; r++) {
                const i = rows[r].indexOf(c);
                if (i !== -1) return r * 10 + i;
            }
            return 30;
        },
        finishGame() {
            this.clearTimer();
            this.phase = "finished";
            this.endTime = performance.now();
            submitTyperGelResult(
                this.score,
                this.wpm,
                this.accuracy * 100,
            ).catch(() => {});
        },
        startAnimation() {
            const loop = () => {
                if (this.phase === "active") {
                    const now = performance.now();
                    this.activeBubbles.forEach((b) => {
                        b.y += b.speed * 0.016;
                        if (b.y > 85 && !b.isCompleted) {
                            b.isFailed = true;
                            this.activeBubbles = this.activeBubbles.filter(
                                (x) => x.id !== b.id,
                            );
                            this.spawnBubble();
                        }
                    });
                    if (
                        now - this.lastSpawnTime > 2000 &&
                        this.activeBubbles.length < this.maxConcurrentBubbles
                    ) {
                        this.spawnBubble();
                        this.lastSpawnTime = now;
                    }
                }
                this.animationFrameId = requestAnimationFrame(loop);
            };
            this.animationFrameId = requestAnimationFrame(loop);
        },
        stopAnimation() {
            if (this.animationFrameId)
                cancelAnimationFrame(this.animationFrameId);
        },
        initCharacterBreathing() {
            if (this.$refs.characterHead)
                gsap.to(this.$refs.characterHead, {
                    y: -5,
                    duration: 2,
                    repeat: -1,
                    yoyo: true,
                    ease: "power1.inOut",
                });
        },
        createBackgroundParticles() {
            for (let i = 0; i < 20; i++)
                this.backgroundParticles.push({
                    x: Math.random() * 100,
                    y: Math.random() * 100,
                    size: Math.random() * 4 + 1,
                });
        },
        initSounds() {
            this.correctSound = new Howl({
                src: ["/audio/correct.mp3"],
                volume: 0.2,
            });
            this.wrongSound = new Howl({
                src: ["/audio/wrong.mp3"],
                volume: 0.2,
            });
            this.typeSound = new Howl({
                src: ["/audio/shot.mp3"],
                volume: 0.1,
            });
        },
        resetGame() {
            this.clearTimer();
            this.phase = "idle";
            this.activeBubbles = [];
            this.score = 0;
            this.correctChars = 0;
        },
    },
};
</script>

<style scoped>
.perspective-1000 {
    perspective: 1000px;
}
.transform-style-preserve-3d {
    transform-style: preserve-3d;
}
.rotateX-20 {
    transform: rotateX(25deg);
}
.hand-realistic {
    width: 60px;
    height: 80px;
    position: relative;
}
.wrist {
    width: 30px;
    height: 10px;
    background: #666;
    margin: 0 auto;
    border-radius: 2px;
}
.palm {
    width: 45px;
    height: 40px;
    background: #444;
    margin: 0 auto;
    border-radius: 5px;
}
.fingers {
    display: flex;
    justify-content: center;
    margin-top: -5px;
}
.finger {
    width: 8px;
    height: 20px;
    background: #333;
    margin: 0 1px;
    border-radius: 3px;
}
@keyframes shake-anim {
    0%,
    100% {
        transform: translate(-50%, -50%) translateX(0);
    }
    25% {
        transform: translate(-50%, -50%) translateX(-4px);
    }
    75% {
        transform: translate(-50%, -50%) translateX(4px);
    }
}
.shake-anim {
    animation: shake-anim 0.2s infinite;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
