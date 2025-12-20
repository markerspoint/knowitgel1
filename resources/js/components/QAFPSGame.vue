<template>
  <div class="min-h-screen bg-black text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#1a237e] via-black to-[#4a148c] opacity-80"></div>

    <div class="relative z-20 flex flex-col h-screen">
      <nav class="flex items-center justify-between px-6 py-4 bg-black bg-opacity-40 backdrop-blur border-b border-white border-opacity-10">
        <div class="flex items-center space-x-2">
          <i class="fas fa-crosshairs text-xl"></i>
          <span class="font-semibold">Q&A FPS Training</span>
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

      <div class="flex-1 relative overflow-hidden" @click="handleShot" @mousemove="handleMouseMove">
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

        <div class="absolute inset-0 pointer-events-none">
          <div
            class="absolute w-10 h-10 flex items-center justify-center"
            :style="{
              left: mouseX + 'px',
              top: mouseY + 'px',
              transform: 'translate(-50%, -200%)'
            }"
          >
            <div class="absolute w-px h-8 bg-white bg-opacity-70"></div>
            <div class="absolute h-px w-8 bg-white bg-opacity-70"></div>
            <div class="w-3 h-3 rounded-full border border-white border-opacity-70"></div>
          </div>
        </div>

        <div class="absolute top-6 left-1/2 -translate-x-1/2 max-w-2xl w-full px-4">
          <div class="bg-black bg-opacity-60 border border-white border-opacity-20 rounded-lg px-6 py-4 shadow-lg">
            <div class="flex items-center justify-between mb-2 text-xs uppercase tracking-wide opacity-70">
              <span>Question {{ currentIndex + 1 }} / {{ totalQuestions }}</span>
              <span>Time Left: {{ remainingTime.toFixed(1) }}s</span>
            </div>
            <div class="w-full h-2 bg-white bg-opacity-10 rounded-full overflow-hidden mb-3">
              <div
                class="h-full bg-gradient-to-r from-[#00e676] via-[#ffeb3b] to-[#ff1744] transition-all duration-100"
                :style="{ width: timerBarWidth + '%' }"
              ></div>
            </div>
            <p class="text-lg md:text-xl font-semibold text-center min-h-[3rem]">
              <span v-if="currentQuestion">{{ currentQuestion.question }}</span>
              <span v-else class="opacity-60">Loading question...</span>
            </p>
          </div>
        </div>

        <div class="absolute inset-0">
          <div
            v-for="bubble in bubbles"
            :key="bubble.id"
            class="absolute flex items-center justify-center rounded-full border border-white border-opacity-40 text-sm md:text-base font-medium text-center px-4 py-3 select-none transition-transform duration-150"
            :style="{
              left: bubble.x + '%',
              top: bubble.y + '%',
              transform: 'translate(-50%, -50%)',
              background: 'rgba(0,0,0,0.6)',
              minWidth: '120px',
              maxWidth: '220px',
              transition: 'none'
            }"
            :data-bubble-id="bubble.id"
          >
            <span class="px-2">{{ bubble.text }}</span>
          </div>
        </div>

        <div
          v-if="phase === 'feedback' && feedbackType === 'correct'"
          class="absolute inset-0 bg-green-400 bg-opacity-40 pointer-events-none animate-pulse"
        ></div>
        <div
          v-if="phase === 'feedback' && feedbackType === 'wrong'"
          class="absolute inset-0 bg-black bg-opacity-70 pointer-events-none"
        ></div>

        <div
          v-if="showMuzzleFlash"
          class="absolute inset-0 bg-white bg-opacity-30 pointer-events-none"
          style="animation: muzzleFlash 0.1s ease-out;"
        ></div>

        <div
          v-if="phase === 'active'"
          class="absolute bottom-0 left-1/2 pointer-events-none z-30 sniper-container"
          :class="{ 'gun-recoil': showGunRecoil }"
          :style="{ 
            transform: `translateX(-50%) rotate(${gunRotation}deg)`,
            '--rot': gunRotation + 'deg'
          }"
        >
          <!-- Realistic Sniper Rifle using Image Asset -->
          <div class="sniper-rifle-image-container">
            <img
              src="/images/sniper-rifle.png"
              alt="Sniper Rifle"
              class="sniper-rifle-image"
              @error="handleGunImageError"
            />
          </div>
          
          <!-- Simple placeholder if image fails -->
          <div v-if="gunImageError" class="gun-placeholder">
            <div class="gun-placeholder-text">Sniper Rifle</div>
          </div>
          
          <!-- Muzzle Flash Effect -->
          <div
            v-if="showMuzzleFlash"
            class="absolute"
            style="left: 30px; bottom: 165px; width: 40px; height: 40px; background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(255,200,100,0.8) 20%, rgba(255,100,0,0.6) 40%, transparent 70%); border-radius: 50%; pointer-events: none; transform: translate(-50%, -50%); filter: blur(2px);"
          ></div>
        </div>

        <div
          v-if="phase === 'idle'"
          class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-70"
        >
          <h2 class="text-3xl font-bold mb-4">Q&A Shooting Training</h2>
          <p class="mb-6 opacity-80 max-w-xl text-center">
            Aim with the crosshair and shoot the correct answer bubble before time runs out.
          </p>
          <div class="flex space-x-4 mb-6">
            <button
              class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold"
              @click="startWithDifficulty('easy')"
            >
              Easy (15s)
            </button>
            <button
              class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold"
              @click="startWithDifficulty('medium')"
            >
              Medium (10s)
            </button>
            <button
              class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold"
              @click="startWithDifficulty('hard')"
            >
              Hard (5s)
            </button>
          </div>
          <p v-if="errorMessage" class="text-red-400 text-sm mt-2">{{ errorMessage }}</p>
        </div>

        <div
          v-if="phase === 'finished'"
          class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-80"
        >
          <h2 class="text-3xl font-bold mb-2 text-white">
            {{ gameWon ? '🎉 Victory!' : gameOver ? 'Game Over' : 'Session Complete' }}
          </h2>
          <p v-if="gameWon" class="mb-2 text-lg text-green-400 font-semibold">You answered all questions correctly!</p>
          <p v-else-if="gameOver" class="mb-2 text-lg text-red-400 font-semibold">You answered incorrectly twice on a question.</p>
          <p class="mb-1 opacity-90 text-lg text-white">Score: {{ score }} / {{ totalQuestions }}</p>
          <p class="mb-4 text-sm opacity-70 text-white">
            Correct: {{ correctCount }} | Incorrect: {{ incorrectCount }}
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

        <div class="absolute bottom-4 left-4 text-xs opacity-70">
          <div>Score: {{ score }}</div>
          <div>Correct: {{ correctCount }} | Wrong: {{ incorrectCount }}</div>
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
import { fetchQAFPSQuestions, submitQAFPSResult } from '../services/qaFpsApi';

export default {
  name: 'QAFPSGame',
  data() {
    return {
      questions: [],
      currentIndex: 0,
      currentQuestion: null,
      difficulty: 'easy',
      remainingTime: 0,
      timerId: null,
      phase: 'idle',
      questionLocked: false,
      score: 0,
      correctCount: 0,
      incorrectCount: 0,
      wrongAnswersForCurrentQuestion: 0,
      gameWon: false,
      gameOver: false,
      feedbackType: null,
      errorMessage: '',
      bubbles: [],
      backgroundParticles: [],
      hoveredBubbleId: null,
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
      gunImageError: false
    };
  },
  computed: {
    totalQuestions() {
      return this.questions.length;
    },
    timerBarWidth() {
      const base =
        this.difficulty === 'easy'
          ? 15
          : this.difficulty === 'medium'
          ? 10
          : 5;
      if (!base) return 0;
      const value = (this.remainingTime / base) * 100;
      return Math.max(0, Math.min(100, value));
    }
  },
  mounted() {
    this.createBackgroundParticles();
    this.initSounds();
    this.updateGunPivot();
    window.addEventListener('resize', this.updateGunPivot);
  },
  beforeUnmount() {
    this.clearTimer();
    this.stopAnimation();
    window.removeEventListener('resize', this.updateGunPivot);
  },
  methods: {
    startWithDifficulty(level) {
      this.difficulty = level;
      this.errorMessage = '';
      this.fetchQuestionsAndStart();
    },
    fetchQuestionsAndStart() {
      this.phase = 'loading';
      fetchQAFPSQuestions(this.difficulty)
        .then(response => {
          this.questions = response.data.questions || [];
          this.currentIndex = 0;
          this.score = 0;
          this.correctCount = 0;
          this.incorrectCount = 0;
          this.wrongAnswersForCurrentQuestion = 0;
          this.gameWon = false;
          this.gameOver = false;
          if (!this.questions.length) {
            this.errorMessage = 'No questions available. Please contact the administrator.';
            this.phase = 'idle';
            return;
          }
          this.loadCurrentQuestion();
        })
        .catch(() => {
          this.errorMessage = 'Failed to load questions. Please try again.';
          this.phase = 'idle';
        });
    },
    loadCurrentQuestion() {
      this.clearTimer();
      this.stopAnimation();
      this.questionLocked = false;
      this.feedbackType = null;
      this.errorMessage = '';
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
      this.phase = 'active';
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
      const minDistance = 12;
      const maxAttempts = 100;
      
      options.forEach((text, index) => {
        let x, y;
        let attempts = 0;
        let validPosition = false;
        
        while (!validPosition && attempts < maxAttempts) {
          x = 15 + Math.random() * 70;
          y = 20 + Math.random() * 60;
          validPosition = true;
          
          for (const existingBubble of result) {
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
          y = 20 + Math.random() * 60;
        }
        
        const angle = Math.random() * Math.PI * 2;
        const speed = 0.02 + Math.random() * 0.03;
        result.push({
          id: index,
          text,
          x,
          y,
          vx: Math.cos(angle) * speed,
          vy: Math.sin(angle) * speed,
          isCorrect: text === this.currentQuestion.correct_answer
        });
      });
      this.bubbles = result;
    },
    checkBubbleCollision(bubble1, bubble2, minDistance = 12) {
      const distance = Math.sqrt(
        Math.pow(bubble1.x - bubble2.x, 2) + Math.pow(bubble1.y - bubble2.y, 2)
      );
      return distance < minDistance;
    },
    startTimerForDifficulty() {
      const base =
        this.difficulty === 'easy'
          ? 15
          : this.difficulty === 'medium'
          ? 10
          : 5;
      this.remainingTime = base;
      this.clearTimer();
      const step = 0.1;
      this.timerId = setInterval(() => {
        if (this.phase !== 'active') {
          return;
        }
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
      if (this.phase !== 'active' || this.questionLocked) {
        return;
      }
      if (!this.bubbles.length) {
        return;
      }
      
      const clickX = event.clientX;
      const clickY = event.clientY;
      let hitBubble = null;
      
      this.showMuzzleFlash = true;
      this.showGunRecoil = true;
      setTimeout(() => {
        this.showMuzzleFlash = false;
        this.showGunRecoil = false;
      }, 100);
      
      if (this.shotSound) {
        this.shotSound.play();
      }
      
      const elements = document.querySelectorAll('[data-bubble-id]');
      elements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (
          clickX >= rect.left &&
          clickX <= rect.right &&
          clickY >= rect.top &&
          clickY <= rect.bottom
        ) {
          const idAttr = el.getAttribute('data-bubble-id');
          const id = parseInt(idAttr, 10);
          const bubble = this.bubbles.find(b => b.id === id);
          if (bubble && !hitBubble) {
            hitBubble = bubble;
          }
        }
      });
      
      if (!hitBubble) {
        return;
      }
      this.handleBubbleHit(hitBubble);
    },
    handleMouseMove(event) {
      this.mouseX = event.clientX;
      this.mouseY = event.clientY;
      this.updateGunRotation();
    },
    updateGunPivot() {
      this.gunPivotX = window.innerWidth * 0.52;
      this.gunPivotY = window.innerHeight * 0.85;
    },
    updateGunRotation() {
      if (this.phase !== 'active') {
        return;
      }
      
      const deltaX = this.mouseX - this.gunPivotX;
      const deltaY = this.mouseY - this.gunPivotY;
      
      let angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);
      
      angle += 90;
      angle += 20;
      
      if (angle > 180) angle -= 360;
      if (angle < -180) angle += 360;
      
      angle = Math.max(-65, Math.min(25, angle));
      
      this.targetRotation = angle;
    },
    handleBubbleHit(bubble) {
      if (this.questionLocked) {
        return;
      }
      this.questionLocked = true;
      this.clearTimer();
      this.stopAnimation();
      const isCorrect = bubble.isCorrect;
      if (isCorrect) {
        this.score += 1;
        this.correctCount += 1;
        this.feedbackType = 'correct';
        if (this.correctSound) {
          this.correctSound.play();
        }
        this.speakFeedback('Good job!');
        this.phase = 'feedback';
        setTimeout(() => {
          this.currentIndex += 1;
          this.loadCurrentQuestion();
        }, 1200);
      } else {
        this.incorrectCount += 1;
        this.wrongAnswersForCurrentQuestion += 1;
        this.feedbackType = 'wrong';
        if (this.wrongSound) {
          this.wrongSound.play();
        }
        
        if (this.wrongAnswersForCurrentQuestion >= 2) {
          this.speakFeedback('Game Over!');
          this.phase = 'feedback';
          setTimeout(() => {
            this.finishGame(false);
          }, 1200);
        } else {
        this.speakFeedback('Oh no, try again!');
      this.phase = 'feedback';
      setTimeout(() => {
            this.questionLocked = false;
            this.feedbackType = null;
            this.phase = 'active';
            this.startTimerForDifficulty();
            this.startAnimation();
      }, 1200);
        }
      }
    },
    handleTimeout() {
      if (this.questionLocked || this.phase !== 'active') {
        return;
      }
      this.questionLocked = true;
      this.stopAnimation();
      this.incorrectCount += 1;
      this.wrongAnswersForCurrentQuestion += 1;
      this.feedbackType = 'wrong';
      this.phase = 'feedback';
      
      if (this.wrongAnswersForCurrentQuestion >= 2) {
        this.speakFeedback('Game Over!');
        setTimeout(() => {
          this.finishGame(false);
        }, 1200);
      } else {
      this.speakFeedback('Oh no, try again!');
      setTimeout(() => {
          this.questionLocked = false;
          this.feedbackType = null;
          this.phase = 'active';
          this.startTimerForDifficulty();
          this.startAnimation();
      }, 1200);
      }
    },
    finishGame(isWin = false) {
      this.clearTimer();
      this.phase = 'finished';
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
      this.phase = 'idle';
      this.errorMessage = '';
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
        volume: 0.5
      });
      this.wrongSound = new Howl({
        src: ['/audio/wrong.mp3'],
        volume: 0.5
      });
      this.shotSound = new Howl({
        src: ['/audio/shot.mp3'],
        volume: 0.4
      });
    },
    startAnimation() {
      if (this.animationFrameId) {
        cancelAnimationFrame(this.animationFrameId);
      }
      this.animateBubbles();
    },
    stopAnimation() {
      if (this.animationFrameId) {
        cancelAnimationFrame(this.animationFrameId);
        this.animationFrameId = null;
      }
    },
    animateBubbles() {
      if (this.phase !== 'active') {
        return;
      }
      
      const minDistance = 12;
      
      this.bubbles.forEach((bubble, index) => {
        const oldX = bubble.x;
        const oldY = bubble.y;
        
        bubble.x += bubble.vx;
        bubble.y += bubble.vy;
        
        if (bubble.x < 10 || bubble.x > 90) {
          bubble.vx *= -1;
          bubble.x = Math.max(10, Math.min(90, bubble.x));
        }
        if (bubble.y < 15 || bubble.y > 85) {
          bubble.vy *= -1;
          bubble.y = Math.max(15, Math.min(85, bubble.y));
        }
        
        for (let j = index + 1; j < this.bubbles.length; j++) {
          const otherBubble = this.bubbles[j];
          if (this.checkBubbleCollision(bubble, otherBubble, minDistance)) {
            const dx = bubble.x - otherBubble.x;
            const dy = bubble.y - otherBubble.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance > 0) {
              const overlap = minDistance - distance;
              const separationX = (dx / distance) * overlap * 0.5;
              const separationY = (dy / distance) * overlap * 0.5;
              
              bubble.x += separationX;
              bubble.y += separationY;
              otherBubble.x -= separationX;
              otherBubble.y -= separationY;
              
              const relativeVx = bubble.vx - otherBubble.vx;
              const relativeVy = bubble.vy - otherBubble.vy;
              const dotProduct = relativeVx * dx + relativeVy * dy;
              
              if (dotProduct < 0) {
                const collisionAngle = Math.atan2(dy, dx);
                const speed1 = Math.sqrt(bubble.vx * bubble.vx + bubble.vy * bubble.vy);
                const speed2 = Math.sqrt(otherBubble.vx * otherBubble.vx + otherBubble.vy * otherBubble.vy);
                const angle1 = Math.atan2(bubble.vy, bubble.vx);
                const angle2 = Math.atan2(otherBubble.vy, otherBubble.vx);
                
                const newAngle1 = collisionAngle - (angle1 - collisionAngle);
                const newAngle2 = collisionAngle - (angle2 - collisionAngle);
                
                bubble.vx = Math.cos(newAngle1) * speed1 * 0.8;
                bubble.vy = Math.sin(newAngle1) * speed1 * 0.8;
                otherBubble.vx = Math.cos(newAngle2) * speed2 * 0.8;
                otherBubble.vy = Math.sin(newAngle2) * speed2 * 0.8;
              }
            }
          }
        }
      });
      
      if (this.phase === 'active') {
        this.gunRotation += (this.targetRotation - this.gunRotation) * 0.2;
        this.animationFrameId = requestAnimationFrame(this.animateBubbles);
      }
    },
    speakFeedback(text) {
      if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.volume = 0.8;
        utterance.rate = 1.0;
        utterance.pitch = 1.0;
        speechSynthesis.speak(utterance);
      }
    },
    handleGunImageError(event) {
      this.gunImageError = true;
      event.target.style.display = 'none';
    }
  }
};
</script>

<style scoped>
@keyframes muzzleFlash {
  0% {
    opacity: 0.8;
  }
  100% {
    opacity: 0;
  }
}

.sniper-container {
  transform-origin: center bottom;
  will-change: transform;
}

.sniper-rifle {
  filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.8));
  transition: none;
}

.gun-recoil {
  animation: gunRecoil 0.1s ease-out;
}

@keyframes gunRecoil {
  0% {
    transform: translateX(-50%) translateX(0) rotate(var(--rot));
  }
  50% {
    transform: translateX(-50%) translateX(-14px) rotate(var(--rot));
  }
  100% {
    transform: translateX(-50%) translateX(0) rotate(var(--rot));
  }
}

.sniper-rifle-image-container {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: flex-end;
  justify-content: center;
}

.sniper-rifle-image {
  width: 650px;
  height: auto;
  max-height: 400px;
  object-fit: contain;
  filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.85));
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
  transform: translateY(120px);
  transform-origin: 20% 80%;
}

.gun-placeholder {
  width: 650px;
  height: 300px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.5);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 8px;
}

.gun-placeholder-text {
  color: rgba(255, 255, 255, 0.5);
  font-size: 18px;
  text-transform: uppercase;
  letter-spacing: 2px;
}

@media (max-width: 768px) {
  .sniper-rifle {
    width: 400px;
    height: 200px;
  }
  .sniper-rifle-image {
    width: 500px;
    max-height: 350px;
  }
  .gun-placeholder {
    width: 500px;
    height: 250px;
  }
}
</style>
