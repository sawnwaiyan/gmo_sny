<div x-data="{ questionnaire: {{ json_encode($questionnaire) }} }">
    <template x-for="(question, index) in questionnaire" :key="index">
        <div class="card mb-4">
            <div class="card-header">
                <h2 x-text="`質問 ${index + 1}: ${question.question}`"></h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
                        <li class="list-group-item" x-text="option"></li>
                    </template>
                </ul>
            </div>
        </div>
    </template>
</div>
