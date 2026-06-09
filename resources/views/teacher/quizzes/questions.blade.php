@extends('teacher.layouts.app')
@section('title', __('Administer Test Questions') . ' - ' . $quiz->title)
@section('breadcrumb', $quiz->title)

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="background:rgba(16,185,129,.1);color:var(--green);border:1px solid rgba(16,185,129,.2);border-radius:var(--radius-md);">
    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter:invert(1);"></button>
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="ed-card" style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:var(--radius-md);">
            <div class="ed-card-header" style="border-bottom:1px solid var(--card-border);">
                <div class="ed-card-title"><i class="fa-solid fa-list-check me-2" style="color:var(--brand);"></i>{{ __('Test questions') }} ({{ $questions->count() }})</div>
            </div>
            <div class="ed-card-body d-flex flex-column gap-4" style="padding:20px;">
                @forelse($questions as $question)
                    <div style="padding:20px;border:1.5px solid var(--card-border);border-radius:var(--radius-md);background:var(--card-bg2);position:relative;margin-bottom:16px;">
                        <div style="position:absolute;right:20px;top:20px;display:flex;align-items:center;gap:12px;">
                            <span class="ed-badge ed-badge-indigo" style="font-size:11.5px;background:rgba(99, 102, 241, 0.1);color:#6366f1;">{{ $question->points }} {{ __('point') }}</span>
                            
                            {{-- Edit Button --}}
                            <button type="button" class="btn btn-sm p-0 border-0 edit-question-btn" 
                                    data-id="{{ $question->id }}"
                                    data-question="{{ e(json_encode($question->question)) }}"
                                    data-points="{{ $question->points }}"
                                    data-explanation="{{ e(json_encode($question->explanation)) }}"
                                    data-options="{{ e(json_encode($question->options)) }}"
                                    style="background:none;border:none;outline:none;cursor:pointer;color:#6366f1;font-size:13px;"
                                    title="{{ __('Edit question') }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            {{-- Delete Button/Form --}}
                            <form action="{{ route('teacher.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this question?') }}');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-0 border-0" 
                                        style="background:none;border:none;outline:none;cursor:pointer;font-size:13px;"
                                        title="{{ __('Delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <h5 style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:16px;max-width:85%;">
                            {{ $loop->iteration }}. {{ $question->question }}
                        </h5>
                        
                        <div class="row g-2">
                            @foreach($question->options as $index => $option)
                                <div class="col-sm-6">
                                    <div style="padding:10px 12px;border-radius:var(--radius-md);font-size:13px;
                                                @if($option->is_correct)
                                                    background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.35);color:var(--green);font-weight:700;
                                                @else
                                                    background:rgba(255,255,255,.03);border:1px solid var(--card-border);color:var(--text-muted);
                                                @endif">
                                        <i class="fa-solid @if($option->is_correct) fa-circle-check @else fa-circle @endif me-2"></i>
                                        {{ $option->option_text }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($question->explanation)
                            <div class="mt-3" style="font-size:12.5px;color:var(--text-muted);background:rgba(255,255,255,.02);padding:10px 12px;border-radius:var(--radius-md);border-left:2.5px solid var(--brand);">
                                <strong>{{ __('Explanation') }}:</strong> {{ $question->explanation }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div style="font-size:40px;margin-bottom:14px;">📝</div>
                        <div style="font-weight:700;color:var(--text);font-size:15px;">{{ __('Questions have not been created') }}</div>
                        <div style="color:var(--text-muted);font-size:13px;margin-top:6px;">{{ __('Add questions using the form on the right to run the quiz') }}.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        {{-- Add new question form --}}
        <div class="ed-card h-100">
            <div class="ed-card-header">
                <div>
                    <div class="ed-card-title" id="form-card-title"><i class="fa-solid fa-plus me-2" style="color:var(--brand);"></i>{{ __('Add a new question') }}</div>
                    <div class="ed-card-subtitle" id="form-card-subtitle">{{ __('Write the test question and answer options') }}</div>
                </div>
            </div>

            <div class="ed-card-body">
                <form action="{{ route('teacher.quizzes.questions.store', $quiz->id) }}" method="POST" id="question-form">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;color:var(--text);">{{ __('Question text') }} <span class="text-danger">*</span></label>
                        <textarea name="question" rows="3" class="form-control" placeholder="{{ __('Write the content of the question...') }}" style="background:var(--card-bg2);border:1px solid var(--card-border);color:var(--text);" required>{{ old('question') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;color:var(--text);">{{ __('This is the point of the question') }} <span class="text-danger">*</span></label>
                        <input type="number" name="points" class="form-control" value="10" min="1" style="background:var(--card-bg2);border:1px solid var(--card-border);color:var(--text);" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;color:var(--text);">{{ __('Explanation of the correct answer') }} ({{ __('optional') }})</label>
                        <textarea name="explanation" rows="2" class="form-control" placeholder="{{ __('The explanation that the student will see after completing the test...') }}" style="background:var(--card-bg2);border:1px solid var(--card-border);color:var(--text);">{{ old('explanation') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="font-weight:700;color:var(--text);display:block;margin-bottom:12px;">{{ __('Answer options') }} ({{ __('minimal') }} 2, {{ __('choose the right one') }}):</label>
                        
                        <div class="d-flex flex-column gap-3">
                            @for($i = 0; $i < 4; $i++)
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-check-inline" style="margin:0;">
                                        <input class="form-check-input" type="radio" name="correct_option" id="correctOpt{{ $i }}" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }} style="transform:scale(1.2);accent-color:var(--brand);cursor:pointer;">
                                    </div>
                                    <input type="text" name="options[]" class="form-control" placeholder="{{ __('Option') }} {{ $i+1 }}" style="background:var(--card-bg2);border:1px solid var(--card-border);color:var(--text);" {{ $i < 2 ? 'required' : '' }}>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="ed-btn flex-grow-1" id="submit-btn" style="background:var(--brand);color:#fff;border:0;">
                            <i class="fa-solid fa-plus" id="submit-icon"></i> <span id="submit-text">{{ __('Add question') }}</span>
                        </button>
                        <button type="button" class="ed-btn btn-secondary d-none" id="cancel-edit-btn" style="background:var(--card-border);color:var(--text);border:0;">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-question-btn');
    const form = document.getElementById('question-form');
    const formMethod = document.getElementById('form-method');
    const formTitle = document.getElementById('form-card-title');
    const formSubtitle = document.getElementById('form-card-subtitle');
    const submitBtn = document.getElementById('submit-btn');
    const submitIcon = document.getElementById('submit-icon');
    const submitText = document.getElementById('submit-text');
    const cancelBtn = document.getElementById('cancel-edit-btn');
    
    // Inputs
    const questionTextarea = form.querySelector('textarea[name="question"]');
    const pointsInput = form.querySelector('input[name="points"]');
    const explanationTextarea = form.querySelector('textarea[name="explanation"]');
    const optionInputs = form.querySelectorAll('input[name="options[]"]');
    const correctRadios = form.querySelectorAll('input[name="correct_option"]');

    const storeUrl = "{{ route('teacher.quizzes.questions.store', $quiz->id) }}";

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const question = JSON.parse(this.getAttribute('data-question'));
            const points = this.getAttribute('data-points');
            const explanation = JSON.parse(this.getAttribute('data-explanation'));
            const options = JSON.parse(this.getAttribute('data-options'));

            // Update form action and method
            form.setAttribute('action', `/teacher/quizzes/{{ $quiz->id }}/questions/${id}`);
            formMethod.value = 'PUT';

            // Update form headers and buttons
            formTitle.innerHTML = `<i class="fa-solid fa-pen me-2" style="color:var(--brand);"></i>{{ __('Edit question') }}`;
            formSubtitle.textContent = "{{ __('Update the question and answer options') }}";
            
            submitIcon.className = "fa-solid fa-save";
            submitText.textContent = "{{ __('Save') }}";
            cancelBtn.classList.remove('d-none');

            // Populate text fields
            questionTextarea.value = question;
            pointsInput.value = points;
            explanationTextarea.value = explanation || '';

            // Clear all check states first
            correctRadios.forEach(radio => radio.checked = false);

            // Populate option fields
            optionInputs.forEach((input, index) => {
                const optionData = options[index];
                if (optionData) {
                    input.value = optionData.option_text;
                    if (optionData.is_correct) {
                        correctRadios[index].checked = true;
                    }
                } else {
                    input.value = '';
                }
            });

            // Scroll to form on mobile devices
            form.scrollIntoView({ behavior: 'smooth' });
        });
    });

    cancelBtn.addEventListener('click', function() {
        // Reset form action and method
        form.setAttribute('action', storeUrl);
        formMethod.value = 'POST';

        // Reset form headers and buttons
        formTitle.innerHTML = `<i class="fa-solid fa-plus me-2" style="color:var(--brand);"></i>{{ __('Add a new question') }}`;
        formSubtitle.textContent = "{{ __('Write the test question and answer options') }}";
        
        submitIcon.className = "fa-solid fa-plus";
        submitText.textContent = "{{ __('Add question') }}";
        cancelBtn.classList.add('d-none');

        // Reset form inputs
        form.reset();
        
        // Ensure default correct option is checked
        if (correctRadios.length > 0) {
            correctRadios[0].checked = true;
        }
    });
});
</script>
@endsection