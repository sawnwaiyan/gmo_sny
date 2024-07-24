// resources/js/validation.js
export const validationRules = {
    required: (value) => !!value || 'この項目は必須です。',
    minLength: (length) => (value) =>
        !value || value.length >= length || `${length}文字以上で入力してください。`,
    maxLength: (length) => (value) =>
        !value || value.length <= length || `${length}文字以内で入力してください。`,
    email: (value) =>
        !value || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || '有効なメールアドレスを入力してください。',
    min: (min) => (value) =>
        !value || Number(value) >= min || `${min}以上の値を入力してください。`,
    max: (max) => (value) =>
        !value || Number(value) <= max || `${max}以下の値を入力してください。`,
    integer: (value) =>
        !value || Number.isInteger(Number(value)) || value===0 || '整数を入力してください。',
    date: (value) => {
        if (!value) return true;
        const date = new Date(value);
        return !isNaN(date.getTime()) || '有効な日付を入力してください。';
    },
    phoneNumber: (value) =>
        !value || /^[0-9-+()]{7,15}$/.test(value) || '有効な電話番号を入力してください。',
    url: (value) =>
        !value || /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(value) || '有効なURLを入力してください。',
    alphanumeric: (value) =>
        !value || /^[a-zA-Z0-9]*$/.test(value) || '英数字のみ入力してください。',
    password: (value) =>
        !value || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/.test(value) || 'パスワードは8文字以上で、大文字、小文字、数字を含める必要があります。',
    range: (min, max) => (value) =>
        !value || (Number(value) >= min && Number(value) <= max) || `${min}から${max}の間の値を入力してください。`,
    fileSize: (maxSize) => (file) =>
        !file || file.size <= maxSize || `ファイルサイズは${maxSize / 1000000}MB以下にしてください。`,
    fileType: (types) => (file) =>
        !file || types.includes(file.type) || '許可されていないファイル形式です。'
};

export function validateField(value, rules) {
    for (const rule of rules) {
        const validationFunction = typeof rule === 'function' ? rule : validationRules[rule];
        const result = validationFunction(value);
        if (typeof result === 'string') {
            return result;
        }
    }
    return '';
}

export function validateForm(formData, formRules) {
    const errors = {};
    for (const field in formRules) {
        errors[field] = validateField(formData[field], formRules[field]);
    }
    return errors;
}
