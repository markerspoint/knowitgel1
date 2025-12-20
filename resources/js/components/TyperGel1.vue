<template>
  <div class="min-h-screen bg-black text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#1a237e] via-black to-[#4a148c] opacity-80"></div>

    <div class="relative z-20 flex flex-col h-screen">
      <nav class="flex items-center justify-between px-6 py-4 bg-black bg-opacity-40 backdrop-blur border-b border-white border-opacity-10">
        <div class="flex items-center space-x-2">
          <i class="fas fa-keyboard text-xl"></i>
          <span class="font-semibold">TyperGel1 Typing Trainer</span>
        </div>
        <div class="flex items-center space-x-4 text-sm">
          <div class="flex items-center space-x-2">
            <span class="opacity-80">Difficulty:</span>
            <span class="font-semibold capitalize">{{ difficulty }}</span>
          </div>
          <button
            class="px-3 py-1 rounded bg-gradient-to-r from-[#667eea] to-[#764ba2] hover:from-[#5568d3] hover:to-[#6a3a9f] text-white font-semibold border border-white border-opacity-20 transition-all duration-200 shadow-lg"
            @click="resetGame"
          >
            Restart
          </button>
          <button
            class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 text-white font-semibold border border-gray-500 border-opacity-50 transition-all duration-200 shadow-lg"
            @click="$router.push('/user/dashboard')"
          >
            Exit
          </button>
        </div>
      </nav>

      <div class="flex-1 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
          <div
            v-for="(p, index) in backgroundParticles"
            :key="index"
            class="absolute rounded-full opacity-40"
            :style="{
              width: p.size + 'px',
              height: p.size + 'px',
              left: p.x + '%',
              top: p.y + '%',
              background: p.color,
              boxShadow: '0 0 ' + p.size * 2 + 'px ' + p.color
            }"
          ></div>
        </div>

        <div class="absolute top-6 left-1/2 -translate-x-1/2 max-w-3xl w-full px-4">
          <div class="bg-black bg-opacity-60 border border-white border-opacity-20 rounded-lg px-6 py-4 shadow-lg">
            <div class="flex items-center justify-between mb-2 text-xs uppercase tracking-wide opacity-70">
              <span>Time Left: {{ remainingTime.toFixed(1) }}s</span>
              <span>WPM: {{ wpm.toFixed(1) }} | Accuracy: {{ (accuracy * 100).toFixed(0) }}%</span>
            </div>
            <div class="w-full h-2 bg-white bg-opacity-10 rounded-full overflow-hidden mb-3">
              <div
                class="h-full bg-gradient-to-r from-[#00e676] via-[#ffeb3b] to-[#ff1744] transition-all duration-100"
                :style="{ width: timerBarWidth + '%' }"
              ></div>
            </div>
            <p class="text-sm opacity-80 text-center">
              Type the words in the bubbles before they reach you. Focus on accuracy first, speed second.
            </p>
          </div>
        </div>

        <div class="absolute inset-0">
          <div
            v-for="bubble in activeBubbles"
            :key="bubble.id"
            class="absolute flex flex-col items-center justify-center rounded-full border border-white border-opacity-40 text-sm md:text-base font-medium text-center px-4 py-3 select-none transition-all duration-300"
            :class="{
              'bg-green-500 bg-opacity-70': bubble.isCompleted,
              'bg-red-600 bg-opacity-70': bubble.isFailed,
              'bg-red-500 bg-opacity-80 border-red-400': bubble.showIncorrect,
              'bg-black bg-opacity-60': !bubble.isCompleted && !bubble.isFailed && !bubble.showIncorrect,
              'ring-2 ring-cyan-400 ring-opacity-80': bubble.id === focusedBubbleId && !bubble.showIncorrect
            }"
            :style="{
              left: bubble.x + '%',
              top: bubble.y + '%',
              transform: 'translate(-50%, -50%)',
              minWidth: '120px',
              maxWidth: '220px'
            }"
          >
            <span class="px-2">
              <span
                v-for="(char, index) in bubble.text.split('')"
                :key="index"
                :class="{
                  'text-cyan-300': index < bubble.progress && !bubble.showIncorrect,
                  'text-white': index >= bubble.progress && !bubble.showIncorrect,
                  'text-red-200': bubble.showIncorrect
                }"
              >
                {{ char }}
              </span>
            </span>
          </div>
        </div>

        <div
          v-if="phase === 'idle'"
          class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-70"
        >
          <h2 class="text-3xl font-bold mb-4">TyperGel1 Typing Practice</h2>
          <p class="mb-6 opacity-80 max-w-xl text-center">
            Bubbles with IT-related words will float towards you. Type each word before it reaches your position.
          </p>
          <div class="flex space-x-4 mb-4">
            <button
              class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold"
              @click="startWithDifficulty('easy')"
            >
              Easy
            </button>
            <button
              class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold"
              @click="startWithDifficulty('medium')"
            >
              Medium
            </button>
            <button
              class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold"
              @click="startWithDifficulty('hard')"
            >
              Hard
            </button>
          </div>
          <p v-if="errorMessage" class="text-red-400 text-sm mt-2">{{ errorMessage }}</p>
        </div>

         <div
           v-if="phase === 'finished'"
           class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-80"
         >
           <h2 class="text-3xl font-bold mb-2 text-white">{{ gameWon ? '🎉 Victory!' : 'Session Complete' }}</h2>
           <p v-if="gameWon" class="mb-2 text-lg text-green-400 font-semibold">You completed all words!</p>
           <p class="mb-1 opacity-90 text-lg text-white">Score: {{ score }}</p>
           <p class="mb-1 text-sm opacity-80 text-white">
             WPM: {{ wpm.toFixed(1) }} | Accuracy: {{ (accuracy * 100).toFixed(0) }}%
           </p>
           <p class="mb-4 text-sm opacity-70 text-white">
             Correct chars: {{ correctChars }} | Incorrect chars: {{ incorrectChars }}
           </p>
           <div class="flex flex-wrap justify-center gap-4">
             <button
               class="px-4 py-2 rounded-lg bg-white hover:bg-gray-100 border border-white border-opacity-30 text-black font-semibold transition-all duration-200"
               @click="resetGame"
             >
               Play Again
             </button>
             <button
               class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#f59e0b] to-[#d97706] hover:from-[#d97706] hover:to-[#b45309] text-white font-semibold transition-all duration-200 shadow-lg"
               @click="$router.push('/leaderboard')"
             >
               <i class="fas fa-trophy mr-2"></i>Leaderboards
             </button>
             <button
               class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold transition-all duration-200"
               @click="$router.push('/user/dashboard')"
             >
               Back to Dashboard
             </button>
           </div>
         </div>

        <div
          class="absolute bottom-0 left-1/2 transform -translate-x-1/2 flex items-end justify-center pointer-events-none z-30 keyboard-container"
        >
          <div
            class="relative w-[420px] h-[220px] flex items-end justify-center keyboard-perspective"
            ref="keyboardContainer"
          >
            <div class="absolute bottom-0 w-full h-24 bg-black bg-opacity-70 rounded-t-3xl border-t border-white border-opacity-20 keyboard-base"></div>
            <div class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-cyan-500/10 to-transparent rounded-t-3xl pointer-events-none"></div>
            <div class="relative z-10 flex items-end space-x-4 pb-6">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#90caf9] to-[#1e88e5] flex items-center justify-center shadow-lg character-head" ref="characterHead">
                <div class="w-16 h-16 rounded-full bg-black bg-opacity-80"></div>
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-white/20 to-transparent"></div>
              </div>
              <div class="typing-setup">
                <div class="keyboard-and-hands-container">
                  <div class="hands-container">
                    <div class="hand-left-wrapper" ref="handLeft">
                      <div class="hand-realistic hand-left">
                        <div class="wrist"></div>
                        <div class="palm"></div>
                        <div class="fingers">
                          <div class="finger finger-1"></div>
                          <div class="finger finger-2"></div>
                          <div class="finger finger-3"></div>
                          <div class="finger finger-4"></div>
                          <div class="thumb"></div>
                        </div>
                      </div>
                    </div>
                    <div class="hand-right-wrapper" ref="handRight">
                      <div class="hand-realistic hand-right">
                        <div class="wrist"></div>
                        <div class="palm"></div>
                        <div class="fingers">
                          <div class="finger finger-1"></div>
                          <div class="finger finger-2"></div>
                          <div class="finger finger-3"></div>
                          <div class="finger finger-4"></div>
                          <div class="thumb"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="keyboard-wrapper" ref="keyboardWrapper">
                    <div class="keyboard-base-container">
                      <div class="keyboard-frame">
                        <div class="keyboard-glow"></div>
                        <div class="keyboard-body">
                          <div class="keyboard-row keyboard-row-1">
                            <div v-for="i in 10" :key="'r1-' + i" 
                              :ref="el => { if (el) keyboardKeyRefs[i-1] = el }"
                              class="key-wrapper" 
                              :data-key-index="i-1">
                              <div class="key-cap" :class="getKeyClass(i-1)">
                                <div class="key-led" :style="{ background: getKeyLEDColor(i-1) }"></div>
                                <div class="key-top">
                                  <div class="key-shine"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="keyboard-row keyboard-row-2">
                            <div v-for="i in 10" :key="'r2-' + i" 
                              :ref="el => { if (el) keyboardKeyRefs[10+i-1] = el }"
                              class="key-wrapper"
                              :data-key-index="10+i-1">
                              <div class="key-cap" :class="getKeyClass(10+i-1)">
                                <div class="key-led" :style="{ background: getKeyLEDColor(10+i-1) }"></div>
                                <div class="key-top">
                                  <div class="key-shine"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="keyboard-row keyboard-row-3">
                            <div v-for="i in 10" :key="'r3-' + i" 
                              :ref="el => { if (el) keyboardKeyRefs[20+i-1] = el }"
                              class="key-wrapper"
                              :data-key-index="20+i-1">
                              <div class="key-cap" :class="getKeyClass(20+i-1)">
                                <div class="key-led" :style="{ background: getKeyLEDColor(20+i-1) }"></div>
                                <div class="key-top">
                                  <div class="key-shine"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="keyboard-row keyboard-row-4">
                            <div class="key-wrapper key-spacebar" 
                              :ref="el => { if (el) keyboardKeyRefs[30] = el }"
                              :data-key-index="30">
                              <div class="key-cap" :class="getKeyClass(30)">
                                <div class="key-led" :style="{ background: getKeyLEDColor(30) }"></div>
                                <div class="key-top">
                                  <div class="key-shine"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="absolute bottom-4 left-4 text-xs opacity-70">
          <div>Score: {{ score }}</div>
          <div>Correct: {{ correctChars }} | Wrong: {{ incorrectChars }}</div>
        </div>

        <div v-if="errorMessage && phase !== 'idle'" class="absolute bottom-4 right-4 text-xs text-red-400">
          {{ errorMessage }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Howl } from 'howler';
import { gsap } from 'gsap';
import { fetchTyperGelConfig, submitTyperGelResult } from '../services/typerGelApi';

export default {
  name: 'TyperGel1',
  data() {
    return {
      difficulty: 'easy',
      phase: 'idle',
      remainingTime: 0,
      timerId: null,
      backgroundParticles: [],
      activeBubbles: [],
      wordPool: [],
      originalWordPool: [],
      availableWords: [],
      activeWordTexts: new Set(),
      focusedBubbleId: null,
      currentInput: '',
      gameWon: false,
      score: 0,
      totalChars: 0,
      correctChars: 0,
      incorrectChars: 0,
      mistakes: 0,
      startTime: null,
      endTime: null,
      maxConcurrentBubbles: 3,
      bubbleSpawnInterval: 2000,
      lastSpawnTime: 0,
      characterTypingTimeout: null,
      isTyping: false,
      correctSound: null,
      wrongSound: null,
      typeSound: null,
      animationFrameId: null,
      errorMessage: '',
      keyboardKeys: new Array(31).fill(null).map((_, i) => ({ id: i, char: '' })),
      keyboardKeyRefs: [],
      pressedKeyIndex: null,
      lastKeyCorrect: null,
      rgbLightingOffset: 0,
      gsapTimelines: {
        keyPress: null,
        hands: null,
        character: null
      },
      lastHandAnimated: 'right'
    };
  },
  computed: {
    timerBarWidth() {
      const base = this.getDifficultyConfig(this.difficulty).durationSeconds;
      if (!base) return 0;
      const value = (this.remainingTime / base) * 100;
      return Math.max(0, Math.min(100, value));
    },
    elapsedSeconds() {
      if (!this.startTime) return 0;
      const end = this.endTime || performance.now();
      return (end - this.startTime) / 1000;
    },
    wpm() {
      if (this.elapsedSeconds <= 0) return 0;
      return (this.correctChars / 5) / (this.elapsedSeconds / 60);
    },
    accuracy() {
      const total = this.correctChars + this.incorrectChars;
      if (total === 0) return 1;
      return this.correctChars / total;
    }
  },
  mounted() {
    this.createBackgroundParticles();
    this.initSounds();
    window.addEventListener('keydown', this.handleKeydown);
    this.startAnimation();
    this.$nextTick(() => {
      this.keyboardKeyRefs = new Array(31).fill(null);
      this.initCharacterBreathing();
      console.log('Hands initialized:', {
        leftHand: !!this.$refs.handLeft,
        rightHand: !!this.$refs.handRight
      });
    });
  },
  beforeUnmount() {
    window.removeEventListener('keydown', this.handleKeydown);
    this.clearTimer();
    this.stopAnimation();
    this.cleanupGSAPAnimations();
    if (this.characterTypingTimeout) {
      clearTimeout(this.characterTypingTimeout);
      this.characterTypingTimeout = null;
    }
  },
  methods: {
    startWithDifficulty(level) {
      this.difficulty = level;
      this.errorMessage = '';
      this.fetchConfigAndStart();
    },
    fetchConfigAndStart() {
      this.phase = 'loading';
      fetchTyperGelConfig(this.difficulty)
        .then(response => {
          const data = response.data || {};
          const words = data.words || [];
          this.originalWordPool = words.map((item, index) => ({
            id: index,
            text: typeof item === 'string' ? item : item.word
          }));
          if (!this.originalWordPool.length) {
            this.errorMessage = 'No words available. Please contact the administrator.';
            this.phase = 'idle';
            return;
          }
          this.resetStats();
          this.startCoreLoop();
        })
        .catch(() => {
          this.errorMessage = 'Failed to load typing data. Please try again.';
          this.phase = 'idle';
        });
    },
    resetStats() {
      this.activeBubbles = [];
      this.focusedBubbleId = null;
      this.currentInput = '';
      this.score = 0;
      this.totalChars = 0;
      this.correctChars = 0;
      this.incorrectChars = 0;
      this.mistakes = 0;
      this.startTime = performance.now();
      this.endTime = null;
      this.availableWords = [...this.originalWordPool];
      this.activeWordTexts.clear();
      const config = this.getDifficultyConfig(this.difficulty);
      this.maxConcurrentBubbles = config.maxConcurrentBubbles;
      this.bubbleSpawnInterval = config.spawnIntervalMs;
      this.remainingTime = config.durationSeconds;
      this.lastSpawnTime = performance.now();
      this.clearTimer();
      this.startTimer();
    },
    startCoreLoop() {
      this.phase = 'active';
      this.spawnInitialBubbles();
    },
    spawnInitialBubbles() {
      const count = Math.min(this.maxConcurrentBubbles, this.availableWords.length);
      for (let i = 0; i < count; i++) {
        this.spawnBubble();
      }
    },
    spawnBubble() {
      let candidates = this.availableWords.filter(w => !this.activeWordTexts.has(w.text));
      
      if (candidates.length === 0) {
        return;
      }
      
      const index = Math.floor(Math.random() * candidates.length);
      const wordData = candidates[index];
      const config = this.getDifficultyConfig(this.difficulty);
      const speed = config.bubbleSpeed;
      const id = `${Date.now()}-${Math.random().toString(36).slice(2)}`;
      
      const minDistance = 15;
      const maxAttempts = 100;
      let x, y;
      let attempts = 0;
      let validPosition = false;
      
      y = -10;
      
      while (!validPosition && attempts < maxAttempts) {
        x = 15 + Math.random() * 70;
        validPosition = true;
        
        for (const existingBubble of this.activeBubbles) {
          if (existingBubble.isCompleted || existingBubble.isFailed) {
            continue;
          }
          const distance = Math.sqrt(
            Math.pow(x - existingBubble.x, 2) + Math.pow(y - existingBubble.y, 2)
          );
          if (distance < minDistance) {
            validPosition = false;
            break;
          }
        }
        attempts++;
      }
      
      if (!validPosition) {
        x = 15 + Math.random() * 70;
      }
      
      this.activeBubbles.push({
        id,
        text: wordData.text,
        wordId: wordData.id,
        wordText: wordData.text,
        x,
        y,
        speed,
        progress: 0,
        isCompleted: false,
        isFailed: false,
        showIncorrect: false,
        incorrectTimeout: null,
        spawnTime: performance.now()
      });
      
      this.activeWordTexts.add(wordData.text);
    },
    checkBubbleCollision(bubble1, bubble2, minDistance = 15) {
      const distance = Math.sqrt(
        Math.pow(bubble1.x - bubble2.x, 2) + Math.pow(bubble1.y - bubble2.y, 2)
      );
      return distance < minDistance;
    },
    getDifficultyConfig(level) {
      if (level === 'easy') {
        return {
          durationSeconds: 90,
          bubbleSpeed: 6,
          spawnIntervalMs: 2200,
          maxConcurrentBubbles: 3,
          maxMistakes: 999
        };
      }
      if (level === 'medium') {
        return {
          durationSeconds: 75,
          bubbleSpeed: 9,
          spawnIntervalMs: 1800,
          maxConcurrentBubbles: 4,
          maxMistakes: 999
        };
      }
      return {
        durationSeconds: 60,
        bubbleSpeed: 13,
        spawnIntervalMs: 1500,
        maxConcurrentBubbles: 5,
        maxMistakes: 999
      };
    },
    startTimer() {
      const step = 0.1;
      this.timerId = setInterval(() => {
        if (this.phase !== 'active') {
          return;
        }
        this.remainingTime = Math.max(0, this.remainingTime - step);
        if (this.remainingTime <= 0) {
          this.remainingTime = 0;
          this.handleTimeUp();
        }
      }, step * 1000);
    },
    clearTimer() {
      if (this.timerId) {
        clearInterval(this.timerId);
        this.timerId = null;
      }
    },
    handleTimeUp() {
      if (this.phase !== 'active') {
        return;
      }
      this.finishGame();
    },
    handleKeydown(event) {
      if (this.phase !== 'active') {
        return;
      }
      if (event.metaKey || event.ctrlKey || event.altKey) {
        return;
      }
      const key = event.key;
      if (key.length !== 1 && key !== 'Backspace' && key !== ' ') {
        return;
      }
      
      if (key === 'Backspace') {
        this.triggerTypingAnimation();
        this.handleBackspace();
        return;
      }
      if (key === ' ') {
        event.preventDefault();
        const keyIndex = this.getKeyIndexForChar(' ');
        this.triggerTypingAnimation(keyIndex, null);
        return;
      }
      this.processCharacter(key);
    },
    handleBackspace() {
      if (!this.focusedBubbleId) {
        return;
      }
      const bubble = this.activeBubbles.find(b => b.id === this.focusedBubbleId);
      if (!bubble || bubble.isCompleted || bubble.isFailed) {
        return;
      }
      if (bubble.progress > 0) {
        bubble.progress -= 1;
        this.totalChars = Math.max(0, this.totalChars - 1);
      }
    },
    processCharacter(rawChar) {
      const char = rawChar.toLowerCase();
      this.totalChars += 1;
      if (this.typeSound) {
        this.typeSound.play();
      }
      
      const keyIndex = this.getKeyIndexForChar(char);
      this.triggerTypingAnimation(keyIndex, null);
      
      if (this.focusedBubbleId) {
        const bubble = this.activeBubbles.find(b => b.id === this.focusedBubbleId);
        if (bubble && !bubble.isCompleted && !bubble.isFailed) {
          this.applyCharToBubble(bubble, char, keyIndex);
          return;
        }
      }
      const candidates = this.activeBubbles.filter(b => !b.isCompleted && !b.isFailed);
      let chosen = null;
      let minDistance = Infinity;
      candidates.forEach(b => {
        const nextChar = b.text.charAt(b.progress).toLowerCase();
        if (nextChar === char) {
          const distance = 100 - b.y;
          if (distance < minDistance) {
            minDistance = distance;
            chosen = b;
          }
        }
      });
      if (chosen) {
        this.focusedBubbleId = chosen.id;
        this.applyCharToBubble(chosen, char, keyIndex);
      } else {
        this.incorrectChars += 1;
        this.mistakes += 1;
        if (this.wrongSound) {
          this.wrongSound.play();
        }
        this.triggerTypingAnimation(keyIndex, false);
        if (this.focusedBubbleId) {
          const focusedBubble = this.activeBubbles.find(b => b.id === this.focusedBubbleId);
          if (focusedBubble && !focusedBubble.isCompleted && !focusedBubble.isFailed) {
            this.showIncorrectIndicator(focusedBubble);
          }
        }
      }
    },
    applyCharToBubble(bubble, char, keyIndex) {
      const expected = bubble.text.charAt(bubble.progress).toLowerCase();
      if (expected === char) {
        this.clearIncorrectIndicator(bubble);
        bubble.progress += 1;
        this.correctChars += 1;
        if (this.correctSound) {
          this.correctSound.play();
        }
        this.score += 10;
        this.triggerTypingAnimation(keyIndex, true);
        if (bubble.progress >= bubble.text.length) {
          bubble.isCompleted = true;
          this.score += 40;
          this.focusedBubbleId = null;
          this.scheduleBubbleRemoval(bubble.id, true);
        }
      } else {
        this.incorrectChars += 1;
        this.mistakes += 1;
        if (this.wrongSound) {
          this.wrongSound.play();
        }
        this.score = Math.max(0, this.score - 5);
        this.triggerTypingAnimation(keyIndex, false);
        this.showIncorrectIndicator(bubble);
      }
    },
    showIncorrectIndicator(bubble) {
      if (bubble.incorrectTimeout) {
        clearTimeout(bubble.incorrectTimeout);
      }
      bubble.showIncorrect = true;
      bubble.incorrectTimeout = setTimeout(() => {
        this.clearIncorrectIndicator(bubble);
      }, 1000);
    },
    clearIncorrectIndicator(bubble) {
      if (bubble.incorrectTimeout) {
        clearTimeout(bubble.incorrectTimeout);
        bubble.incorrectTimeout = null;
      }
      bubble.showIncorrect = false;
    },
    scheduleBubbleRemoval(id, spawnReplacement) {
      setTimeout(() => {
        const bubble = this.activeBubbles.find(b => b.id === id);
        if (bubble) {
          this.clearIncorrectIndicator(bubble);
          if (bubble.isCompleted) {
            const wordIndex = this.availableWords.findIndex(w => w.text === bubble.text);
            if (wordIndex !== -1) {
              this.availableWords.splice(wordIndex, 1);
            }
          }
          this.activeWordTexts.delete(bubble.text);
        }
        this.activeBubbles = this.activeBubbles.filter(b => b.id !== id);
        
        if (this.phase === 'active') {
          this.checkWinCondition();
          
          if (spawnReplacement && this.activeBubbles.length < this.maxConcurrentBubbles && this.availableWords.length > 0) {
            this.spawnBubble();
          }
        }
      }, 300);
    },
    checkWinCondition() {
      if (this.availableWords.length === 0 && this.activeBubbles.filter(b => !b.isCompleted && !b.isFailed).length === 0) {
        this.finishGame(true);
      }
    },
    updateBubbles(delta) {
      if (this.phase !== 'active') {
        return;
      }
      const config = this.getDifficultyConfig(this.difficulty);
      const minDistance = 15;
      
      this.activeBubbles.forEach((bubble, index) => {
        if (bubble.isCompleted || bubble.isFailed) {
          return;
        }
        
        const oldY = bubble.y;
        bubble.y += (bubble.speed * delta) / 1000;
        
        if (bubble.y >= 88) {
          bubble.isFailed = true;
          this.mistakes += 1;
          this.score = Math.max(0, this.score - 20);
          this.focusedBubbleId = this.focusedBubbleId === bubble.id ? null : this.focusedBubbleId;
          this.scheduleBubbleRemoval(bubble.id, false);
          return;
        }
        
        for (let j = index + 1; j < this.activeBubbles.length; j++) {
          const otherBubble = this.activeBubbles[j];
          if (otherBubble.isCompleted || otherBubble.isFailed) {
            continue;
          }
          
          if (this.checkBubbleCollision(bubble, otherBubble, minDistance)) {
            const dx = bubble.x - otherBubble.x;
            const dy = bubble.y - otherBubble.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance > 0) {
              const overlap = minDistance - distance;
              const separationX = (dx / distance) * overlap * 0.5;
              
              bubble.x += separationX;
              otherBubble.x -= separationX;
              
              bubble.x = Math.max(10, Math.min(90, bubble.x));
              otherBubble.x = Math.max(10, Math.min(90, otherBubble.x));
            }
          }
        }
      });
      
      const now = performance.now();
      if (now - this.lastSpawnTime >= this.bubbleSpawnInterval) {
        const activeCount = this.activeBubbles.filter(b => !b.isCompleted && !b.isFailed).length;
        if (activeCount < config.maxConcurrentBubbles && this.availableWords.length > 0) {
          this.spawnBubble();
        }
        this.lastSpawnTime = now;
        this.checkWinCondition();
      }
    },
    startAnimation() {
      let lastTime = performance.now();
      const loop = () => {
        const now = performance.now();
        const delta = now - lastTime;
        lastTime = now;
        this.updateBubbles(delta);
        this.rgbLightingOffset = (this.rgbLightingOffset + 0.5) % 360;
        if (this.phase === 'active') {
          this.animationFrameId = requestAnimationFrame(loop);
        } else {
          this.animationFrameId = requestAnimationFrame(loop);
        }
      };
      this.animationFrameId = requestAnimationFrame(loop);
    },
    stopAnimation() {
      if (this.animationFrameId) {
        cancelAnimationFrame(this.animationFrameId);
        this.animationFrameId = null;
      }
    },
    finishGame(isWin = false) {
      this.clearTimer();
      this.endTime = performance.now();
      this.phase = 'finished';
      this.gameWon = isWin;
      const payload = {
        score: this.score,
        total_chars: this.totalChars,
        correct_chars: this.correctChars,
        incorrect_chars: this.incorrectChars,
        accuracy: this.accuracy,
        wpm: this.wpm,
        difficulty: this.difficulty,
        duration_seconds: this.elapsedSeconds
      };
      submitTyperGelResult(payload).catch(() => {});
    },
    resetGame() {
      this.clearTimer();
      this.stopAnimation();
      this.cleanupGSAPAnimations();
      this.activeBubbles.forEach(bubble => {
        this.clearIncorrectIndicator(bubble);
      });
      this.activeBubbles = [];
      this.availableWords = [];
      this.originalWordPool = [];
      this.activeWordTexts.clear();
      this.focusedBubbleId = null;
      this.currentInput = '';
      this.score = 0;
      this.totalChars = 0;
      this.correctChars = 0;
      this.incorrectChars = 0;
      this.mistakes = 0;
      this.startTime = null;
      this.endTime = null;
      this.gameWon = false;
      this.phase = 'idle';
      this.errorMessage = '';
      this.pressedKeyIndex = null;
      this.lastKeyCorrect = null;
      this.lastHandAnimated = 'right';
      this.rgbLightingOffset = 0;
      if (!this.animationFrameId) {
        this.startAnimation();
      }
    },
    createBackgroundParticles() {
      const colors = [
        'rgba(102, 126, 234, 0.6)',
        'rgba(118, 75, 162, 0.6)',
        'rgba(0, 229, 255, 0.6)',
        'rgba(255, 255, 255, 0.4)'
      ];
      const arr = [];
      for (let i = 0; i < 40; i++) {
        arr.push({
          x: Math.random() * 100,
          y: Math.random() * 100,
          size: Math.random() * 6 + 4,
          color: colors[Math.floor(Math.random() * colors.length)]
        });
      }
      this.backgroundParticles = arr;
    },
    initSounds() {
      this.correctSound = new Howl({
        src: ['/audio/correct.mp3'],
        volume: 0.3
      });
      this.wrongSound = new Howl({
        src: ['/audio/wrong.mp3'],
        volume: 0.3
      });
      this.typeSound = new Howl({
        src: ['/audio/type-key.mp3'],
        volume: 0.15
      });
    },
    getKeyIndexForChar(char) {
      const qwertyLayout = 'qwertyuiopasdfghjklzxcvbnm ';
      const index = qwertyLayout.indexOf(char.toLowerCase());
      if (char === ' ') return 30;
      return index >= 0 && index < 30 ? index : Math.floor(Math.random() * 30);
    },
    getKeyClass(index) {
      const classes = [];
      if (this.pressedKeyIndex === index) {
        classes.push('key-pressed');
        if (this.lastKeyCorrect === true) classes.push('key-correct');
        if (this.lastKeyCorrect === false) classes.push('key-incorrect');
      }
      return classes.join(' ');
    },
    getKeyLEDColor(index) {
      const offset = this.rgbLightingOffset;
      const hue = (index * 10 + offset) % 360;
      return `hsl(${hue}, 80%, 60%)`;
    },
    triggerTypingAnimation(keyIndex = null, isCorrect = null) {
      this.isTyping = true;
      this.pressedKeyIndex = keyIndex;
      this.lastKeyCorrect = isCorrect;
      
      if (keyIndex !== null && this.keyboardKeyRefs[keyIndex]) {
        this.animateKeyPress(keyIndex, isCorrect);
      }
      
      this.$nextTick(() => {
        this.animateHands();
      });
      
      if (this.characterTypingTimeout) {
        clearTimeout(this.characterTypingTimeout);
      }
      this.characterTypingTimeout = setTimeout(() => {
        this.isTyping = false;
        this.pressedKeyIndex = null;
        this.lastKeyCorrect = null;
      }, 180);
    },
    animateKeyPress(keyIndex, isCorrect) {
      if (!this.keyboardKeyRefs || keyIndex < 0 || keyIndex >= this.keyboardKeyRefs.length) return;
      
      const keyElement = this.keyboardKeyRefs[keyIndex];
      if (!keyElement) return;
      
      if (this.gsapTimelines.keyPress) {
        this.gsapTimelines.keyPress.kill();
      }
      
      const keyCap = keyElement.querySelector('.key-cap');
      if (!keyCap) return;
      
      const color = isCorrect === true ? '#00e676' : isCorrect === false ? '#ff1744' : '#90caf9';
      
      this.gsapTimelines.keyPress = gsap.timeline();
      this.gsapTimelines.keyPress
        .to(keyCap, {
          y: 2,
          scale: 0.95,
          duration: 0.08,
          ease: 'power2.out'
        })
        .to(keyCap, {
          y: 0,
          scale: 1,
          duration: 0.1,
          ease: 'power2.in'
        }, '-=0.05');
      
      if (isCorrect !== null) {
        gsap.to(keyCap, {
          boxShadow: `0 0 8px ${color}`,
          duration: 0.1,
          ease: 'power2.out',
          yoyo: true,
          repeat: 1
        });
      }
    },
    animateHands() {
      if (this.gsapTimelines.hands) {
        this.gsapTimelines.hands.kill();
      }
      
      const leftHand = this.$refs.handLeft;
      const rightHand = this.$refs.handRight;
      
      if (!leftHand || !rightHand) {
        console.log('Hand refs not found');
        return;
      }
      
      this.lastHandAnimated = this.lastHandAnimated === 'left' ? 'right' : 'left';
      const activeHand = this.lastHandAnimated === 'left' ? leftHand : rightHand;
      
      const activeFingers = activeHand.querySelectorAll('.finger');
      const activePalm = activeHand.querySelector('.palm');
      
      if (!activeFingers.length || !activePalm) {
        console.log('Finger or palm elements not found');
        return;
      }
      
      this.gsapTimelines.hands = gsap.timeline();
      
      this.gsapTimelines.hands
        .to(activeHand, {
          y: -4,
          duration: 0.06,
          ease: 'power2.out'
        }, 0)
        .to(activeFingers, {
          scaleY: 0.92,
          y: -2,
          duration: 0.06,
          ease: 'power2.out',
          stagger: 0.01
        }, 0)
        .to(activePalm, {
          scaleY: 0.96,
          duration: 0.06,
          ease: 'power2.out'
        }, 0)
        .to(activeHand, {
          y: 0,
          duration: 0.08,
          ease: 'power2.in'
        }, 0.06)
        .to(activeFingers, {
          scaleY: 1,
          y: 0,
          duration: 0.08,
          ease: 'power2.in',
          stagger: 0.01
        }, 0.06)
        .to(activePalm, {
          scaleY: 1,
          duration: 0.08,
          ease: 'power2.in'
        }, 0.06);
    },
    initCharacterBreathing() {
      const characterHead = this.$refs.characterHead;
      if (characterHead) {
        this.gsapTimelines.character = gsap.to(characterHead, {
          scale: 1.02,
          duration: 2,
          ease: 'sine.inOut',
          yoyo: true,
          repeat: -1
        });
      }
      
      this.initHandsIdleAnimation();
    },
    initHandsIdleAnimation() {
      const leftHand = this.$refs.handLeft;
      const rightHand = this.$refs.handRight;
      
      if (!leftHand || !rightHand) {
        console.log('Cannot initialize hand idle animation - refs not found');
        return;
      }
      
      gsap.to(leftHand, {
        y: -2,
        duration: 1.5,
        ease: 'sine.inOut',
        yoyo: true,
        repeat: -1
      });
      
      gsap.to(rightHand, {
        y: -2,
        duration: 1.5,
        ease: 'sine.inOut',
        yoyo: true,
        repeat: -1,
        delay: 0.75
      });
      
      console.log('Hand idle animations initialized');
    },
    cleanupGSAPAnimations() {
      if (this.gsapTimelines.keyPress) {
        this.gsapTimelines.keyPress.kill();
        this.gsapTimelines.keyPress = null;
      }
      if (this.gsapTimelines.hands) {
        this.gsapTimelines.hands.kill();
        this.gsapTimelines.hands = null;
      }
      if (this.gsapTimelines.character) {
        this.gsapTimelines.character.kill();
        this.gsapTimelines.character = null;
      }
    }
  }
};
</script>

<style scoped>
.keyboard-container {
  perspective: 1000px;
}

.keyboard-perspective {
  transform-style: preserve-3d;
  transform: rotateX(8deg) translateZ(0);
  will-change: transform;
}

.keyboard-base {
  transform: translateZ(-10px);
}

.keyboard-base-layer {
  position: relative;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 
    0 4px 20px rgba(0, 0, 0, 0.8),
    inset 0 1px 0 rgba(255, 255, 255, 0.1),
    inset 0 -2px 10px rgba(0, 0, 0, 0.6);
}

.character-head {
  position: relative;
  transform: translateZ(20px);
  box-shadow: 
    0 8px 24px rgba(0, 0, 0, 0.6),
    0 0 20px rgba(144, 202, 249, 0.3);
}

.hands-container {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  pointer-events: none;
  transform: translateZ(30px);
  z-index: 100;
  will-change: transform;
}

.hand-left-wrapper,
.hand-right-wrapper {
  position: relative;
  will-change: transform;
  transform-origin: center bottom;
  margin-bottom: 10px;
  z-index: 101;
}

.hand-left-wrapper {
  margin-left: 30px;
}

.hand-right-wrapper {
  margin-right: 30px;
}

.hand-left-wrapper .hand-realistic,
.hand-right-wrapper .hand-realistic {
  will-change: transform, filter;
}

.hand-realistic {
  position: relative;
  width: 85px;
  height: 110px;
  filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.7));
}

.wrist {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 55px;
  height: 35px;
  background: linear-gradient(to bottom, #7c9cc4 0%, #5a7ea0 100%);
  border-radius: 30px 30px 8px 8px;
  box-shadow: 
    inset 0 2px 8px rgba(0, 0, 0, 0.3),
    0 4px 8px rgba(0, 0, 0, 0.5);
}

.palm {
  position: absolute;
  bottom: 25px;
  left: 50%;
  transform: translateX(-50%);
  width: 65px;
  height: 45px;
  background: linear-gradient(135deg, #90caf9 0%, #64b5f6 50%, #42a5f5 100%);
  border-radius: 50% 50% 30% 30%;
  box-shadow: 
    inset 0 3px 10px rgba(0, 0, 0, 0.2),
    inset 0 -2px 8px rgba(255, 255, 255, 0.2),
    0 4px 12px rgba(0, 0, 0, 0.4);
}

.hand-left .palm {
  border-radius: 50% 50% 30% 40%;
}

.hand-right .palm {
  border-radius: 50% 50% 40% 30%;
}

.fingers {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 85px;
  height: 75px;
  display: flex;
  justify-content: center;
  gap: 2px;
}

.finger {
  width: 13px;
  height: 48px;
  background: linear-gradient(to bottom, #90caf9 0%, #64b5f6 50%, #42a5f5 100%);
  border-radius: 7px 7px 4px 4px;
  position: relative;
  transform-origin: center bottom;
  box-shadow: 
    inset 0 2px 4px rgba(0, 0, 0, 0.2),
    inset 0 -1px 2px rgba(255, 255, 255, 0.2),
    0 3px 6px rgba(0, 0, 0, 0.4);
  will-change: transform;
}

.finger::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 40%;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0.25), transparent);
  border-radius: 7px 7px 0 0;
}

.finger-1 {
  height: 42px;
  transform: rotate(-10deg);
}

.finger-2 {
  height: 50px;
  transform: rotate(-4deg);
}

.finger-3 {
  height: 48px;
  transform: rotate(3deg);
}

.finger-4 {
  height: 41px;
  transform: rotate(8deg);
}

.hand-right .finger-1 {
  transform: rotate(10deg);
}

.hand-right .finger-2 {
  transform: rotate(4deg);
}

.hand-right .finger-3 {
  transform: rotate(-3deg);
}

.hand-right .finger-4 {
  transform: rotate(-8deg);
}

.thumb {
  position: absolute;
  bottom: 12px;
  width: 14px;
  height: 32px;
  background: linear-gradient(to bottom, #90caf9 0%, #64b5f6 50%, #42a5f5 100%);
  border-radius: 7px;
  box-shadow: 
    inset 0 2px 4px rgba(0, 0, 0, 0.2),
    inset 0 -1px 2px rgba(255, 255, 255, 0.2),
    0 3px 6px rgba(0, 0, 0, 0.4);
}

.hand-left .thumb {
  left: -6px;
  transform: rotate(-50deg);
}

.hand-right .thumb {
  right: -6px;
  transform: rotate(50deg);
}

.typing-setup {
  position: relative;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.keyboard-and-hands-container {
  position: relative;
  width: 480px;
  height: 180px;
}

.keyboard-wrapper {
  transform: translateZ(15px);
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
}

.keyboard-base-container {
  width: 480px;
  height: 140px;
  position: relative;
}

.keyboard-frame {
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, #0d0d0d 0%, #050505 100%);
  border-radius: 12px;
  border: 2px solid rgba(255, 255, 255, 0.05);
  box-shadow: 
    0 12px 48px rgba(0, 0, 0, 0.9),
    inset 0 2px 4px rgba(255, 255, 255, 0.03),
    inset 0 -6px 24px rgba(0, 0, 0, 0.8);
  position: relative;
  overflow: visible;
}

.keyboard-glow {
  position: absolute;
  inset: -20px;
  background: radial-gradient(ellipse at center, rgba(144, 202, 249, 0.15), transparent 70%);
  pointer-events: none;
  filter: blur(20px);
}

.keyboard-body {
  padding: 16px 20px;
  display: flex;
  flex-direction: column;
  gap: 6px;
  height: 100%;
  justify-content: center;
}

.keyboard-row {
  display: flex;
  gap: 4px;
  justify-content: center;
}

.key-wrapper {
  position: relative;
  will-change: transform;
}

.key-spacebar {
  width: 200px;
}

.key-cap {
  position: relative;
  width: 28px;
  height: 28px;
  border-radius: 4px;
  transform-style: preserve-3d;
  will-change: transform;
  cursor: default;
  transition: transform 0.1s ease;
}

.key-spacebar .key-cap {
  width: 100%;
}

.key-led {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 3px;
  opacity: 0.6;
  filter: blur(2px);
  transition: all 0.3s ease;
}

.key-top {
  position: absolute;
  inset: 0;
  background: linear-gradient(145deg, #2a2a2a 0%, #1a1a1a 50%, #0a0a0a 100%);
  border-radius: 4px;
  border: 1px solid rgba(0, 0, 0, 0.8);
  border-bottom: 2px solid rgba(0, 0, 0, 0.9);
  box-shadow: 
    inset 0 3px 6px rgba(255, 255, 255, 0.1),
    inset 0 -3px 4px rgba(0, 0, 0, 0.6),
    0 4px 8px rgba(0, 0, 0, 0.5),
    0 2px 0 rgba(255, 255, 255, 0.03);
  overflow: hidden;
}

.key-shine {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 50%;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15), transparent);
  border-radius: 4px 4px 0 0;
}

.key-cap.key-pressed {
  transform: translateY(2px) scale(0.98);
}

.key-cap.key-pressed .key-top {
  box-shadow: 
    inset 0 4px 8px rgba(0, 0, 0, 0.8),
    inset 0 -1px 2px rgba(255, 255, 255, 0.05),
    0 2px 4px rgba(0, 0, 0, 0.6);
  border-bottom-width: 1px;
}

.key-cap.key-pressed .key-led {
  opacity: 1;
  filter: blur(4px);
  height: 6px;
}

.key-cap.key-correct .key-top {
  background: linear-gradient(145deg, #4ade80 0%, #22c55e 50%, #16a34a 100%);
  box-shadow: 
    inset 0 3px 6px rgba(0, 0, 0, 0.4),
    0 0 16px rgba(0, 230, 118, 0.9),
    0 0 32px rgba(0, 230, 118, 0.6),
    0 4px 8px rgba(0, 0, 0, 0.5);
}

.key-cap.key-correct .key-led {
  background: #00e676 !important;
  opacity: 1;
  filter: blur(6px);
  height: 8px;
}

.key-cap.key-incorrect .key-top {
  background: linear-gradient(145deg, #f87171 0%, #ef4444 50%, #dc2626 100%);
  box-shadow: 
    inset 0 3px 6px rgba(0, 0, 0, 0.4),
    0 0 16px rgba(255, 23, 68, 0.9),
    0 0 32px rgba(255, 23, 68, 0.6),
    0 4px 8px rgba(0, 0, 0, 0.5);
}

.key-cap.key-incorrect .key-led {
  background: #ff1744 !important;
  opacity: 1;
  filter: blur(6px);
  height: 8px;
}

@media (max-width: 768px) {
  .keyboard-perspective {
    transform: rotateX(5deg) translateZ(0);
  }
}
</style>


