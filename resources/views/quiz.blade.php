@extends('layouts.app')

@section('content')
    <div x-data="quizApp()" x-init="init()" class="container mx-auto p-4">

        <!-- 로딩 인디케이터 -->
        <div x-show="loading" class="text-center">
            アンケート情報取得中…
        </div>

        <!-- 에러 메시지 -->
        <div x-show="error" class="text-red-500 text-center">
            アンケート情報取得に不具合が発生しました。ネットワークなど確認してください。
        </div>
        {{-- <div class="max-w-sm mx-auto"> --}}
        <div class="bg-gray-100 shadow-md rounded-lg mb-4 p-4 flex">
            <div class="w-1/2 pr-4">
                <p class="text-gray-700 text-base">背景色</p>
                <div id="bgColorPicker" class="mb-4">
                    <!-- Color Picker Element -->
                </div>
                <p class="text-gray-700 text-base">
                    {{-- Selected Color: <span x-text="selectedColor" class="font-bold"></span> --}}
                </p>
            </div>
            <div class="w-1/2 pl-4">
                <p class="text-gray-700 text-base">文字色</p>
                <div id="txtColorPicker" class="mb-4">
                    <!-- Color Picker Element -->
                </div>
                <p class="text-gray-700 text-base">
                    {{-- Selected Color: <span x-text="selectedColor" class="font-bold"></span> --}}
                </p>
            </div>
        </div>
        {{-- </div> --}}
        <!-- アンケート表示 -->
        <div x-show="!loading && !error" class="bg-white shadow-md rounded-lg p-4" x-bind:style="styleObject">
            <div class="mb-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300 ease-in-out"
                        x-bind:style="{ width: `${progress}%` }" x-bind:class="{ 'text-transparent': progress < 30 }"></div>
                </div>
                <p class="text-sm mt-1" x-text="`Question ${currentQuestionIndex} of ${questionnaire.length}`"></p>
            </div>

            <div x-show="!quizCompleted">
                <h2 class="text-2xl font-bold mb-4" x-text="currentQuestion.question"></h2>

                <div class="space-y-2">
                    <template x-for="(option, index) in currentQuestion.options" :key="index">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" x-bind:name="'question_' + currentQuestionIndex"
                                    x-bind:value="index" x-model="currentAnswer"
                                    x-on:change="updateAnswer(currentQuestionIndex, index)">
                                <span class="ml-2" x-text="option"></span>
                            </label>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="quizCompleted" class="mt-4">
                <h2 class="text-2xl font-bold mb-4">Quiz Completed!</h2>
                <div class="bg-gray-100 p-4 rounded">
                    <template x-for="(question, index) in questionnaire" :key="index">
                        <div class="mb-4">
                            <p class="font-bold" x-text="`Question ${index + 1}: ${question.question}`"></p>
                            <p x-text="`Your answer: ${question.options[userAnswers[index]] || '選択なし'}`"></p>
                        </div>
                    </template>
                </div>
                <button x-on:click="submitAnswers"
                    class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    サーバに送信する
                </button>
            </div>

            <div class="mt-4 flex justify-between">
                <button x-on:click="previousQuestion" x-show="currentQuestionIndex > 0 && !quizCompleted"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    戻る
                </button>
                <div x-show="currentQuestionIndex === 0" class="w-20"></div>
                <button x-on:click="nextQuestion" x-show="!quizCompleted"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-auto"
                    x-text="currentQuestionIndex === questionnaire.length - 1 ? '完了' : '次へ'">
                </button>
            </div>
        </div>
    </div>

    <script>
        function quizApp() {
            return {
                questionnaire: [],
                currentQuestionIndex: 0,
                userAnswers: {},
                quizCompleted: false,
                currentAnswer: '',
                loading: true,
                error: false,
                pickers: [{
                        name: 'bgColor',
                        selectedColor: '#FFFFFF'
                    },
                    {
                        name: 'txtColor',
                        selectedColor: '#000000'
                    }
                ],
                async init() {
                    try {
                        const response = await fetch(`/api/questionnaire/1`);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        this.questionnaire = await response.json();
                        this.loading = false;
                    } catch (error) {
                        console.error('Error fetching questionnaire:', error);
                        this.error = true;
                        this.loading = false;
                    }
                    this.initPicker('bgColor');
                    this.initPicker('txtColor');
                },
                initPicker(name) {
                    const index = this.pickers.length;
                    this.pickers.push({
                        name,
                        selectedColor: ''
                    });

                    // Initialize the color picker
                    this.$nextTick(() => {
                        const index = this.pickers.findIndex(p => p.name === name);
                        const pickerElement = document.getElementById(name + "Picker");
                        const pickr = Pickr.create({
                            el: pickerElement,
                            theme: 'classic',
                            default: this.pickers[index].selectedColor,
                            swatches: [
                                'rgba(244, 67, 54, 1)',
                                'rgba(233, 30, 99, 1)',
                                'rgba(156, 39, 176, 1)',
                                'rgba(103, 58, 183, 1)',
                                'rgba(63, 81, 181, 1)',
                                'rgba(33, 150, 243, 1)',
                                'rgba(3, 169, 244, 1)',
                                'rgba(0, 188, 212, 1)',
                                'rgba(0, 150, 136, 1)',
                                'rgba(76, 175, 80, 1)',
                                'rgba(139, 195, 74, 1)',
                                'rgba(205, 220, 57, 1)',
                                'rgba(255, 235, 59, 1)',
                                'rgba(255, 193, 7, 1)',
                                'rgba(0, 0, 0, 1)'
                            ],
                            components: {
                                preview: true,
                                opacity: false,
                                hue: false,
                                interaction: {
                                    hex: true,
                                    rgba: false,
                                    hsla: false,
                                    hsva: false,
                                    cmyk: false,
                                    input: true,
                                    clear: false,
                                    save: false
                                }
                            }
                        }).on('change', (color) => {
                            const newColor = color.toHEXA().toString();
                            this.pickers[index].selectedColor = newColor;
                            pickr.setColor(newColor);
                        });
                    });
                },
                get styleObject() {
                    return {
                        backgroundColor: this.pickers[0].selectedColor,
                        color: this.pickers[1].selectedColor
                    }
                },
                get currentQuestion() {
                    return this.questionnaire.length > 0 ? this.questionnaire[this.currentQuestionIndex] : "";
                },
                get progress() {
                    return (this.currentQuestionIndex / this.questionnaire.length) * 100;
                },
                updateAnswer(questionIndex, answerIndex) {
                    this.userAnswers[questionIndex] = answerIndex;
                },
                nextQuestion() {
                    if (this.currentQuestionIndex < this.questionnaire.length - 1) {
                        this.currentQuestionIndex++;
                        this.currentAnswer = this.userAnswers[this.currentQuestionIndex] !== undefined ?
                            this.userAnswers[this.currentQuestionIndex].toString() :
                            '';
                    } else {
                        this.completeQuiz();
                    }
                },
                previousQuestion() {
                    if (this.currentQuestionIndex > 0) {
                        this.currentQuestionIndex--;
                        this.currentAnswer = this.userAnswers[this.currentQuestionIndex] !== undefined ?
                            this.userAnswers[this.currentQuestionIndex].toString() :
                            '';
                    }
                },
                completeQuiz() {
                    this.quizCompleted = true;
                    this.currentQuestionIndex = this.questionnaire.length;
                    console.log('Quiz completed:', this.formatResults());
                },
                submitAnswers() {
                    const formattedResults = this.formatResults();
                    console.log('Submitting answers:', JSON.stringify(formattedResults));
                    // 例: fetch('/api/submit-quiz', {
                    //     method: 'POST',
                    //     headers: { 'Content-Type': 'application/json' },
                    //     body: JSON.stringify(this.userAnswers)
                    // }).then(response => response.json())
                    //   .then(data => console.log('Server response:', data));
                    alert('Answers submitted successfully!');
                },
                formatResults() {
                    return this.questionnaire.map((q, index) => ({
                        question: q.question,
                        answer: q.options[this.userAnswers[index]] || 'Not answered'
                    }));
                }
            }
        }
    </script>
@endsection
