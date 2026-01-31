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
                            class="fas fa-crosshairs text-red-500 animate-pulse"
                        ></i>
                    </div>
                    <div>
                        <span
                            class="block text-sm font-black uppercase tracking-[0.2em] text-white"
                            >Logic Combat Module</span
                        >
                        <span
                            class="block text-[9px] font-mono text-gray-500 uppercase tracking-widest"
                            >Protocol: Q&A Target Acquisition</span
                        >
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex flex-col items-end">
                        <span
                            class="text-[9px] font-mono text-gray-500 uppercase tracking-widest leading-none"
                            >Matrix Stability</span
                        >
                        <span
                            class="text-xs font-black text-red-500 uppercase tracking-tighter"
                            >{{ difficulty }} MODE</span
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

            <div
                class="flex-1 relative overflow-hidden"
                :class="phase === 'active' ? 'cursor-none' : 'cursor-default'"
                @click="handleShot"
                @mousemove="handleMouseMove"
            >
                <!-- Background Particles (Technical) -->
                <div
                    class="absolute inset-0 pointer-events-none overflow-hidden"
                >
                    <div
                        v-for="(p, index) in backgroundParticles"
                        :key="index"
                        class="absolute opacity-20"
                        :style="{
                            width: p.size + 'px',
                            height: p.size + 'px',
                            left: p.x + '%',
                            top: p.y + '%',
                            background: '#ef4444',
                            boxShadow: '0 0 ' + p.size * 3 + 'px #ef4444',
                            borderRadius: '2px',
                            transform: `rotate(${p.size * 10}deg)`,
                        }"
                    ></div>
                </div>

                <!-- Custom Crosshair (Fixed to Viewport for Accuracy) -->
                <div class="fixed inset-0 pointer-events-none z-[999]">
                    <div
                        class="absolute w-12 h-12 flex items-center justify-center transition-transform duration-75 ease-out"
                        :style="{
                            left: mouseX + 'px',
                            top: mouseY + 'px',
                            transform: 'translate(-50%, -50%)',
                        }"
                    >
                        <!-- Inner Dot -->
                        <div
                            class="w-1.5 h-1.5 bg-red-500 rounded-full shadow-[0_0_10px_#ef4444]"
                        ></div>

                        <!-- Crosshair Bars -->
                        <div
                            class="absolute top-0 h-3 w-[1.5px] bg-red-500/80 shadow-[0_0_5px_rgba(239,68,68,0.5)]"
                        ></div>
                        <div
                            class="absolute bottom-0 h-3 w-[1.5px] bg-red-500/80 shadow-[0_0_5px_rgba(239,68,68,0.5)]"
                        ></div>
                        <div
                            class="absolute left-0 w-3 h-[1.5px] bg-red-500/80 shadow-[0_0_5px_rgba(239,68,68,0.5)]"
                        ></div>
                        <div
                            class="absolute right-0 w-3 h-[1.5px] bg-red-500/80 shadow-[0_0_5px_rgba(239,68,68,0.5)]"
                        ></div>

                        <!-- Modern Corners -->
                        <div
                            class="absolute -top-1.5 -left-1.5 w-2 h-2 border-t-2 border-l-2 border-red-500/50"
                        ></div>
                        <div
                            class="absolute -top-1.5 -right-1.5 w-2 h-2 border-t-2 border-r-2 border-red-500/50"
                        ></div>
                        <div
                            class="absolute -bottom-1.5 -left-1.5 w-2 h-2 border-b-2 border-l-2 border-red-500/50"
                        ></div>
                        <div
                            class="absolute -bottom-1.5 -right-1.5 w-2 h-2 border-b-2 border-r-2 border-red-500/50"
                        ></div>
                    </div>
                </div>

                <!-- Question UI -->
                <div
                    class="absolute top-6 left-1/2 -translate-x-1/2 max-w-lg w-full px-6 transition-all duration-700 z-50"
                    :class="
                        phase === 'active'
                            ? 'translate-y-0 opacity-100'
                            : '-translate-y-20 opacity-0'
                    "
                >
                    <div
                        class="bg-black/70 backdrop-blur-3xl border border-white/10 rounded-2xl p-4 shadow-[0_20px_50px_rgba(0,0,0,0.9)] relative overflow-hidden group"
                    >
                        <!-- Top Glow -->
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 w-48 h-20 bg-red-500/20 blur-[50px] pointer-events-none"
                        ></div>

                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse shadow-[0_0_8px_#ef4444]"
                                ></span>
                                <span
                                    class="text-[8px] font-black text-white uppercase tracking-[0.2em]"
                                    >Query Matrix</span
                                >
                            </div>
                            <div class="flex items-center space-x-4">
                                <span
                                    class="text-[8px] font-mono text-gray-500 uppercase"
                                    >Pkt {{ currentIndex + 1 }}/{{
                                        totalQuestions
                                    }}</span
                                >
                                <span
                                    class="px-2 py-0.5 bg-red-500/10 border border-red-500/20 rounded text-[8px] font-mono text-red-500 font-bold"
                                >
                                    T-{{ remainingTime.toFixed(1) }}s
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar (Modern Technical) -->
                        <div
                            class="w-full h-[1.5px] bg-white/5 rounded-full overflow-hidden mb-4 relative"
                        >
                            <div
                                class="h-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] transition-all duration-100"
                                :style="{ width: timerBarWidth + '%' }"
                            ></div>
                        </div>

                        <p
                            class="text-sm md:text-base font-black text-center text-white uppercase tracking-tight leading-relaxed italic"
                        >
                            <span
                                v-if="currentQuestion"
                                class="drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]"
                            >
                                "{{ currentQuestion.question }}"
                            </span>
                            <span v-else class="text-white/20 animate-pulse"
                                >Initializing Data Stream...</span
                            >
                        </p>
                    </div>
                </div>

                <!-- Target Bubbles (Modern Redesigned) -->
                <div class="absolute inset-0 z-40">
                    <div
                        v-for="bubble in bubbles"
                        :key="bubble.id"
                        class="absolute flex flex-col items-center justify-center p-6 transition-all duration-300 group/bubble select-none shadow-[0_0_20px_rgba(255,255,255,0.05)]"
                        :style="{
                            left: bubble.x + '%',
                            top: bubble.y + '%',
                            transform: 'translate(-50%, -50%)',
                            minWidth: '160px',
                            maxWidth: '280px',
                            transition: 'none',
                        }"
                        :data-bubble-id="bubble.id"
                    >
                        <!-- Orbital Ring -->
                        <div
                            class="absolute inset-0 rounded-2xl border border-white/20 bg-black/60 backdrop-blur-xl group-hover/bubble:bg-red-500/20 group-hover/bubble:border-red-500/60 transition-all duration-300 shadow-xl"
                        ></div>

                        <!-- Technical Accents -->
                        <div
                            class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-red-500/20 group-hover/bubble:border-red-500"
                        ></div>
                        <div
                            class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-red-500/20 group-hover/bubble:border-red-500"
                        ></div>

                        <div class="relative z-10 text-center">
                            <span
                                class="block text-[8px] font-mono text-gray-500 uppercase tracking-widest mb-1 group-hover/bubble:text-red-500/60"
                                >Candidate Option</span
                            >
                            <span
                                class="text-sm font-black text-white uppercase tracking-tight group-hover/bubble:text-red-500 transition-colors"
                            >
                                {{ bubble.text }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Feedback Effects -->
                <transition name="fade">
                    <div
                        v-if="
                            phase === 'feedback' && feedbackType === 'correct'
                        "
                        class="absolute inset-0 z-40 bg-red-500/10 pointer-events-none"
                    >
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <div
                                class="text-[120px] font-black text-red-500/20 uppercase tracking-[0.5em] animate-ping"
                            >
                                CRITICAL HIT
                            </div>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div
                        v-if="phase === 'feedback' && feedbackType === 'wrong'"
                        class="absolute inset-0 z-40 bg-white/5 backdrop-blur-[2px] pointer-events-none flex items-center justify-center"
                    >
                        <div
                            class="text-[120px] font-black text-white/10 uppercase tracking-[0.5em] animate-pulse"
                        >
                            SYSTEM JAM
                        </div>
                    </div>
                </transition>

                <!-- Muzzle Flash Global Intensity -->
                <div
                    v-if="showMuzzleFlash"
                    class="absolute inset-0 bg-red-500/5 pointer-events-none z-50"
                    style="animation: muzzleFlash 0.1s ease-out"
                ></div>

                <!-- Gun Container -->
                <div
                    v-if="phase === 'active'"
                    class="absolute bottom-0 left-1/2 pointer-events-none z-10 sniper-container"
                    :class="{ 'gun-recoil': showGunRecoil }"
                    :style="{
                        transform: `translateX(-50%) rotate(${gunRotation}deg)`,
                        '--rot': gunRotation + 'deg',
                    }"
                >
                    <!-- Enhanced Gun View -->
                    <div class="relative flex flex-col items-center">
                        <!-- Sniper Model -->
                        <img
                            src="/images/sniper-rifle.png"
                            alt="Sniper Rifle"
                            class="sniper-rifle-image drop-shadow-[0_20px_50px_rgba(0,0,0,0.8)]"
                            @error="handleGunImageError"
                        />
                        <!-- Precision Laser Sight -->
                        <div
                            class="absolute h-[2000px] w-px bg-red-500/40 shadow-[0_0_15px_#ef4444] blur-[0.4px] bottom-[350px] animate-pulse"
                            style="transform: translateX(0px)"
                        ></div>
                    </div>

                    <div
                        v-if="gunImageError"
                        class="gun-placeholder border-red-500/20 bg-red-500/5"
                    >
                        <div
                            class="text-red-500 font-mono text-[10px] font-black tracking-widest uppercase"
                        >
                            Weapon Asset Missing
                        </div>
                    </div>
                </div>

                <!-- HUD overlays -->
                <div
                    class="absolute bottom-10 left-10 space-y-4 pointer-events-none z-30"
                >
                    <div
                        class="bg-black/60 backdrop-blur-xl border border-white/5 rounded-2xl p-6 space-y-3 min-w-[180px]"
                    >
                        <div class="flex items-center justify-between">
                            <span
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest"
                                >Logic Links</span
                            >
                            <span class="text-lg font-black text-white">{{
                                score
                            }}</span>
                        </div>
                        <div
                            class="h-[2px] bg-white/5 rounded-full overflow-hidden"
                        >
                            <div
                                class="h-full bg-red-500"
                                :style="{
                                    width: (score / totalQuestions) * 100 + '%',
                                }"
                            ></div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div class="flex flex-col">
                                <span
                                    class="text-[8px] font-mono text-gray-600 uppercase"
                                    >Confirmed</span
                                >
                                <span
                                    class="text-xs font-bold text-green-500"
                                    >{{ correctCount }}</span
                                >
                            </div>
                            <div class="flex flex-col items-end">
                                <span
                                    class="text-[8px] font-mono text-gray-600 uppercase"
                                    >Failed</span
                                >
                                <span class="text-xs font-bold text-red-500">{{
                                    incorrectCount
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Container for Start/Finish -->
                <transition name="fade">
                    <div
                        v-if="phase === 'idle'"
                        class="absolute inset-0 flex flex-col items-center justify-center bg-black/90 backdrop-blur-xl z-200"
                    >
                        <div class="max-w-xl w-full p-12 text-center relative">
                            <!-- Decorative Accents -->
                            <div
                                class="absolute -top-10 left-1/2 -translate-x-1/2 text-red-500/5 text-[180px] font-black -z-10 rotate-12 select-none"
                            >
                                FPS
                            </div>

                            <div
                                class="w-24 h-24 bg-red-500/10 rounded-3xl border border-red-500/30 flex items-center justify-center mx-auto mb-10 transform -rotate-12 group"
                            >
                                <i
                                    class="fas fa-crosshairs text-4xl text-red-500 group-hover:scale-110 transition-transform"
                                ></i>
                            </div>

                            <h2
                                class="text-4xl font-black text-white uppercase tracking-tighter mb-4 italic"
                            >
                                Neural Aim Link
                            </h2>
                            <p
                                class="text-sm text-gray-400 mb-12 font-medium leading-relaxed uppercase tracking-widest"
                            >
                                Synchronize your motor cortex. Identify logic
                                vulnerabilities and eliminate incorrect data
                                strings.
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
                                    >
                                    <span
                                        class="block text-2xl font-black text-white group-hover:scale-105 transition-transform"
                                    >
                                        {{
                                            lvl === "easy"
                                                ? "15s"
                                                : lvl === "medium"
                                                  ? "10s"
                                                  : "5s"
                                        }}
                                    </span>
                                </button>
                            </div>
                            <p
                                v-if="errorMessage"
                                class="text-red-500 text-[10px] font-black uppercase tracking-widest animate-pulse"
                            >
                                {{ errorMessage }}
                            </p>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div
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
                                            : 'fas fa-skull-crossbones',
                                    ]"
                                ></i>
                            </div>

                            <h2
                                class="text-5xl font-black text-white uppercase tracking-tighter mb-2"
                            >
                                {{ gameWon ? "SYNC COMPLETE" : "LINK SEVERED" }}
                            </h2>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-[0.4em] mb-10"
                            >
                                Operation Outcome Status Report
                            </p>

                            <div class="grid grid-cols-3 gap-6 mb-12">
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Efficiency Rating</span
                                    >
                                    <span
                                        class="text-3xl font-black text-white italic"
                                        >{{
                                            Math.round(
                                                (score / totalQuestions) * 100,
                                            )
                                        }}%</span
                                    >
                                </div>
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Confirmed Packs</span
                                    >
                                    <span
                                        class="text-3xl font-black text-white italic"
                                        >{{ score }} /
                                        {{ totalQuestions }}</span
                                    >
                                </div>
                                <div
                                    class="p-6 bg-white/5 border border-white/10 rounded-2xl"
                                >
                                    <span
                                        class="block text-[8px] font-mono text-gray-500 uppercase mb-2"
                                        >Neural Fatigue</span
                                    >
                                    <span
                                        class="text-3xl font-black text-red-500 italic"
                                        >{{ incorrectCount }}</span
                                    >
                                </div>
                            </div>

                            <div class="flex flex-wrap justify-center gap-4">
                                <button
                                    class="px-10 py-4 rounded-xl bg-white text-black font-black uppercase tracking-widest text-[10px] hover:bg-gray-200 transition-all shadow-[0_15px_30px_rgba(255,255,255,0.1)]"
                                    @click="resetGame"
                                >
                                    Re-Initialize Link
                                </button>
                                <button
                                    class="px-10 py-4 rounded-xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px] hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.3)]"
                                    @click="$router.push('/user/dashboard')"
                                >
                                    Exit Terminal
                                </button>
                                <button
                                    class="px-10 py-4 rounded-xl bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest text-[10px] hover:bg-white/10 transition-all"
                                    @click="$router.push('/leaderboard')"
                                >
                                    Node Rankings
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import { Howl } from "howler";
import { fetchQAFPSQuestions, submitQAFPSResult } from "../services/qaFpsApi";

export default {
    name: "QAFPSGame",
    data() {
        return {
            questions: [],
            currentIndex: 0,
            currentQuestion: null,
            difficulty: "easy",
            remainingTime: 0,
            timerId: null,
            phase: "idle",
            questionLocked: false,
            score: 0,
            correctCount: 0,
            incorrectCount: 0,
            wrongAnswersForCurrentQuestion: 0,
            gameWon: false,
            gameOver: false,
            feedbackType: null,
            errorMessage: "",
            bubbles: [],
            backgroundParticles: [],
            correctSound: null,
            wrongSound: null,
            shotSound: null,
            animationFrameId: null,
            showMuzzleFlash: false,
            showGunRecoil: false,
            mouseX: 0,
            mouseY: 0,
            gunRotation: 0,
            targetRotation: 0,
            gunPivotX: 0,
            gunPivotY: 0,
            gunImageError: false,
        };
    },
    computed: {
        totalQuestions() {
            return this.questions.length;
        },
        timerBarWidth() {
            const base =
                this.difficulty === "easy"
                    ? 15
                    : this.difficulty === "medium"
                      ? 10
                      : 5;
            if (!base) return 0;
            const value = (this.remainingTime / base) * 100;
            return Math.max(0, Math.min(100, value));
        },
    },
    mounted() {
        this.createBackgroundParticles();
        this.initSounds();
        this.updateGunPivot();
        window.addEventListener("resize", this.updateGunPivot);
    },
    beforeUnmount() {
        this.clearTimer();
        this.stopAnimation();
        window.removeEventListener("resize", this.updateGunPivot);
    },
    methods: {
        startWithDifficulty(level) {
            this.difficulty = level;
            this.errorMessage = "";
            this.fetchQuestionsAndStart();
        },
        fetchQuestionsAndStart() {
            this.phase = "loading";
            fetchQAFPSQuestions(this.difficulty)
                .then((response) => {
                    this.questions = response.data.questions || [];
                    this.currentIndex = 0;
                    this.score = 0;
                    this.correctCount = 0;
                    this.incorrectCount = 0;
                    this.wrongAnswersForCurrentQuestion = 0;
                    this.gameWon = false;
                    this.gameOver = false;
                    if (!this.questions.length) {
                        this.errorMessage =
                            "Linkage Refused: No data packets in registry.";
                        this.phase = "idle";
                        return;
                    }
                    this.loadCurrentQuestion();
                })
                .catch(() => {
                    this.errorMessage =
                        "Network Error: Neural link handshake failed.";
                    this.phase = "idle";
                });
        },
        loadCurrentQuestion() {
            this.clearTimer();
            this.stopAnimation();
            this.questionLocked = false;
            this.feedbackType = null;
            this.errorMessage = "";
            this.gunRotation = 0;
            this.targetRotation = 0;
            this.wrongAnswersForCurrentQuestion = 0;

            if (this.currentIndex >= this.questions.length) {
                this.finishGame(true);
                return;
            }
            this.currentQuestion = this.questions[this.currentIndex];
            this.spawnBubbles();
            this.startTimerForDifficulty();
            this.phase = "active";
            this.updateGunPivot();
            this.startAnimation();
        },
        spawnBubbles() {
            if (!this.currentQuestion) {
                this.bubbles = [];
                return;
            }
            const options = this.currentQuestion.options || [];
            const result = [];
            const minDistance = 15;
            const maxAttempts = 100;

            options.forEach((text, index) => {
                let x, y;
                let attempts = 0;
                let validPosition = false;

                while (!validPosition && attempts < maxAttempts) {
                    x = 20 + Math.random() * 60;
                    y = 25 + Math.random() * 50;
                    validPosition = true;

                    for (const existingBubble of result) {
                        const distance = Math.sqrt(
                            Math.pow(x - existingBubble.x, 2) +
                                Math.pow(y - existingBubble.y, 2),
                        );
                        if (distance < minDistance) {
                            validPosition = false;
                            break;
                        }
                    }
                    attempts++;
                }

                const angle = Math.random() * Math.PI * 2;
                const speed = 0.015 + Math.random() * 0.02;
                result.push({
                    id: index,
                    text,
                    x,
                    y,
                    vx: Math.cos(angle) * speed,
                    vy: Math.sin(angle) * speed,
                    isCorrect: text === this.currentQuestion.correct_answer,
                });
            });
            this.bubbles = result;
        },
        checkBubbleCollision(bubble1, bubble2, minDistance = 15) {
            const distance = Math.sqrt(
                Math.pow(bubble1.x - bubble2.x, 2) +
                    Math.pow(bubble1.y - bubble2.y, 2),
            );
            return distance < minDistance;
        },
        startTimerForDifficulty() {
            const base =
                this.difficulty === "easy"
                    ? 15
                    : this.difficulty === "medium"
                      ? 10
                      : 5;
            this.remainingTime = base;
            this.clearTimer();
            const step = 0.1;
            this.timerId = setInterval(() => {
                if (this.phase !== "active") return;
                this.remainingTime = Math.max(0, this.remainingTime - step);
                if (this.remainingTime <= 0) {
                    this.remainingTime = 0;
                    this.handleTimeout();
                }
            }, step * 1000);
        },
        clearTimer() {
            if (this.timerId) {
                clearInterval(this.timerId);
                this.timerId = null;
            }
        },
        handleShot(event) {
            if (this.phase !== "active" || this.questionLocked) return;
            if (!this.bubbles.length) return;

            this.showMuzzleFlash = true;
            this.showGunRecoil = true;
            setTimeout(() => {
                this.showMuzzleFlash = false;
                this.showGunRecoil = false;
            }, 80);

            if (this.shotSound) this.shotSound.play();

            // Use current mouse position data for absolute precision
            const hitX = this.mouseX;
            const hitY = this.mouseY;
            let hitBubble = null;

            const elements = document.querySelectorAll("[data-bubble-id]");
            elements.forEach((el) => {
                const rect = el.getBoundingClientRect();
                if (
                    hitX >= rect.left &&
                    hitX <= rect.right &&
                    hitY >= rect.top &&
                    hitY <= rect.bottom
                ) {
                    const id = parseInt(el.getAttribute("data-bubble-id"), 10);
                    const bubble = this.bubbles.find((b) => b.id === id);
                    if (bubble && !hitBubble) hitBubble = bubble;
                }
            });

            if (hitBubble) this.handleBubbleHit(hitBubble);
        },
        handleMouseMove(event) {
            this.mouseX = event.clientX;
            this.mouseY = event.clientY;
            this.updateGunRotation();
        },
        updateGunPivot() {
            this.gunPivotX = window.innerWidth / 2;
            this.gunPivotY = window.innerHeight;
        },
        updateGunRotation() {
            if (this.phase !== "active") return;
            const deltaX = this.mouseX - this.gunPivotX;
            const deltaY = this.mouseY - this.gunPivotY;

            // Calculate angle and normalize so 0 degrees is straight up
            let angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI) + 90;

            // Constrain rotation to realistic sniper swivel
            this.targetRotation = Math.max(-45, Math.min(45, angle));
        },
        handleBubbleHit(bubble) {
            if (this.questionLocked) return;
            this.questionLocked = true;
            this.clearTimer();
            this.stopAnimation();
            const isCorrect = bubble.isCorrect;
            if (isCorrect) {
                this.score += 1;
                this.correctCount += 1;
                this.feedbackType = "correct";
                if (this.correctSound) this.correctSound.play();
                this.speakFeedback("Target Neutralized.");
                this.phase = "feedback";
                setTimeout(() => {
                    this.currentIndex += 1;
                    this.loadCurrentQuestion();
                }, 1000);
            } else {
                this.incorrectCount += 1;
                this.wrongAnswersForCurrentQuestion += 1;
                this.feedbackType = "wrong";
                if (this.wrongSound) this.wrongSound.play();

                if (this.wrongAnswersForCurrentQuestion >= 2) {
                    this.speakFeedback("System Failure.");
                    this.phase = "feedback";
                    setTimeout(() => this.finishGame(false), 1000);
                } else {
                    this.speakFeedback("Fault Detected. Re-acquiring target.");
                    this.phase = "feedback";
                    setTimeout(() => {
                        this.questionLocked = false;
                        this.feedbackType = null;
                        this.phase = "active";
                        this.startTimerForDifficulty();
                        this.startAnimation();
                    }, 1000);
                }
            }
        },
        handleTimeout() {
            if (this.questionLocked || this.phase !== "active") return;
            this.questionLocked = true;
            this.stopAnimation();
            this.incorrectCount += 1;
            this.wrongAnswersForCurrentQuestion += 1;
            this.feedbackType = "wrong";
            this.speakFeedback("Link Timed Out.");
            this.phase = "feedback";

            if (this.wrongAnswersForCurrentQuestion >= 2) {
                setTimeout(() => this.finishGame(false), 1000);
            } else {
                setTimeout(() => {
                    this.questionLocked = false;
                    this.feedbackType = null;
                    this.phase = "active";
                    this.startTimerForDifficulty();
                    this.startAnimation();
                }, 1000);
            }
        },
        finishGame(isWin = false) {
            this.clearTimer();
            this.phase = "finished";
            this.gameWon = isWin;
            this.gameOver = !isWin;
            submitQAFPSResult(this.score).catch(() => {});
        },
        resetGame() {
            this.clearTimer();
            this.stopAnimation();
            this.questions = [];
            this.currentIndex = 0;
            this.currentQuestion = null;
            this.score = 0;
            this.correctCount = 0;
            this.incorrectCount = 0;
            this.wrongAnswersForCurrentQuestion = 0;
            this.gameWon = false;
            this.gameOver = false;
            this.phase = "idle";
            this.errorMessage = "";
        },
        createBackgroundParticles() {
            const arr = [];
            for (let i = 0; i < 30; i++) {
                arr.push({
                    x: Math.random() * 100,
                    y: Math.random() * 100,
                    size: Math.random() * 4 + 2,
                });
            }
            this.backgroundParticles = arr;
        },
        initSounds() {
            this.correctSound = new Howl({
                src: ["/audio/correct.mp3"],
                volume: 0.4,
            });
            this.wrongSound = new Howl({
                src: ["/audio/wrong.mp3"],
                volume: 0.4,
            });
            this.shotSound = new Howl({
                src: ["/audio/shot.mp3"],
                volume: 0.3,
            });
        },
        startAnimation() {
            if (this.animationFrameId)
                cancelAnimationFrame(this.animationFrameId);
            this.animateBubbles();
        },
        stopAnimation() {
            if (this.animationFrameId) {
                cancelAnimationFrame(this.animationFrameId);
                this.animationFrameId = null;
            }
        },
        animateBubbles() {
            if (this.phase !== "active") return;
            const minDistance = 15;
            this.bubbles.forEach((bubble, index) => {
                bubble.x += bubble.vx;
                bubble.y += bubble.vy;
                if (bubble.x < 15 || bubble.x > 85) bubble.vx *= -1;
                if (bubble.y < 20 || bubble.y > 80) bubble.vy *= -1;

                for (let j = index + 1; j < this.bubbles.length; j++) {
                    const other = this.bubbles[j];
                    if (this.checkBubbleCollision(bubble, other, minDistance)) {
                        const dx = bubble.x - other.x;
                        const dy = bubble.y - other.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist > 0) {
                            const overlap = minDistance - dist;
                            bubble.x += (dx / dist) * overlap * 0.5;
                            bubble.y += (dy / dist) * overlap * 0.5;
                            other.x -= (dx / dist) * overlap * 0.5;
                            other.y -= (dy / dist) * overlap * 0.5;
                            bubble.vx *= -1;
                            bubble.vy *= -1;
                            other.vx *= -1;
                            other.vy *= -1;
                        }
                    }
                }
            });
            this.gunRotation += (this.targetRotation - this.gunRotation) * 0.15;
            this.animationFrameId = requestAnimationFrame(this.animateBubbles);
        },
        speakFeedback(text) {
            if ("speechSynthesis" in window) {
                speechSynthesis.cancel();
                const u = new SpeechSynthesisUtterance(text);
                u.rate = 1.1;
                u.pitch = 0.8;
                u.volume = 0.7;
                speechSynthesis.speak(u);
            }
        },
        handleGunImageError(e) {
            this.gunImageError = true;
            e.target.style.display = "none";
        },
    },
};
</script>

<style scoped>
@keyframes muzzleFlash {
    0% {
        opacity: 1;
        filter: brightness(2);
    }
    100% {
        opacity: 0;
        filter: brightness(1);
    }
}

.sniper-container {
    transform-origin: center bottom;
    will-change: transform;
}

.gun-recoil {
    animation: gunRecoil 0.1s cubic-bezier(0.18, 0.89, 0.32, 1.28);
}

@keyframes gunRecoil {
    0% {
        transform: translateX(-50%) translateY(0) rotate(var(--rot));
    }
    50% {
        transform: translateX(-50%) translateY(20px) rotate(var(--rot));
    }
    100% {
        transform: translateX(-50%) translateY(0) rotate(var(--rot));
    }
}

.sniper-rifle-image {
    width: 600px;
    height: auto;
    object-fit: contain;
    filter: brightness(0.9) contrast(1.1)
        drop-shadow(0 15px 30px rgba(0, 0, 0, 0.9));
    transform: translateY(220px);
    transition: filter 0.3s;
}

.sniper-container:hover .sniper-rifle-image {
    filter: brightness(1) contrast(1.1)
        drop-shadow(0 20px 40px rgba(0, 0, 0, 0.9));
}

.gun-placeholder {
    width: 650px;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    border: 1px dashed rgba(239, 68, 68, 0.3);
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
