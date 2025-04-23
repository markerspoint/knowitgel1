<div class="mb-3">
    <label class="form-label">Game Type</label>
    <select class="form-select @error('type') is-invalid @enderror" name="type" id="gameType" required>
        <option value="guess_part">Guess the Computer Part</option>
        <option value="qa">Q&A Game</option>
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3" id="gameFileSection">
    <label class="form-label">Computer Part Image</label>
    <input type="file" class="form-control @error('game_file') is-invalid @enderror" name="game_file" accept="image/*">
    @error('game_file')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Upload an image of the computer part</small>
</div>

<div class="mb-3" id="optionsSection" style="display: none;">
    <label class="form-label">Options (comma separated)</label>
    <input type="text" class="form-control @error('options') is-invalid @enderror" name="options" value="{{ old('options') }}">
    @error('options')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Enter multiple choice options separated by commas</small>
</div>
// ... rest of the form ...

<script>
    document.getElementById('gameType').addEventListener('change', function() {
        const gameType = this.value;
        const gameFileSection = document.getElementById('gameFileSection');
        const optionsSection = document.getElementById('optionsSection');
        
        if (gameType === 'guess_part') {
            gameFileSection.style.display = 'block';
            optionsSection.style.display = 'none';
            document.querySelector('[name="game_file"]').setAttribute('required', '');
            document.querySelector('[name="options"]').removeAttribute('required');
        } else {
            gameFileSection.style.display = 'none';
            optionsSection.style.display = 'block';
            document.querySelector('[name="game_file"]').removeAttribute('required');
            document.querySelector('[name="options"]').setAttribute('required', '');
        }
    });
</script>