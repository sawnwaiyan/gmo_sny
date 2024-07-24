@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">商品編集</h1>

        <div x-data="productForm({{ json_encode($product) }})" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-2xl w-full">
            <div x-show="show" class="p-4 border-l-4"
                :class="{
                    'bg-blue-100 border-blue-500 text-blue-700': message.type === 'info',
                    'bg-green-100 border-green-500 text-green-700': message.type === 'success',
                    'bg-yellow-100 border-yellow-500 text-yellow-700': message.type === 'warning',
                    'bg-red-100 border-red-500 text-red-700': message.type === 'danger'
                }">
                <div class="flex justify-between items-center">
                    <span x-text="message.text"></span>
                    <button @click="show = false" class="text-xl font-bold">&times;</button>
                </div>
            </div>

            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                @csrf

                <x-text-input name="product_name" label="商品名" placeholder="商品名を入力" x-model="formData.product_name" />
                <span x-text="errors.product_name" x-show="errors.product_name" class="text-sm text-red-600 mb-2 ml-2"></span>

                <x-text-input name="price" type="number" label="価格" placeholder="価格を入力" x-model="formData.price" />
                <span x-text="errors.price" x-show="errors.price" class="text-sm text-red-600 mb-2 ml-2"></span>

                <x-textarea-input name="product_description" label="商品説明" placeholder="商品説明を入力" x-model="formData.product_description" />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">商品画像</label>
                    <div class="mt-1 flex items-center">
                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            <template x-if="imageFile.imageUrl || formData.product_image">
                                <img :src="imageFile.imageUrl || '{{ asset('storage') }}/' + formData.product_image" alt="Selected" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!imageFile.imageUrl && !formData.product_image">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </template>
                        </span>
                        <input type="file" name="product_image" accept="image/*" @change="handleFileChange"
                            class="hidden" x-ref="fileInput">
                        <button type="button" @click="$refs.fileInput.click()"
                            class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            ファイルを選択
                        </button>
                    </div>
                    <div x-show="imageFile.fileName" class="mt-2 text-sm text-gray-500" x-text="imageFile.fileName"></div>
                </div>

                <span x-text="errors.product_image" x-show="errors.product_image" class="text-sm text-red-600 mb-2 ml-2"></span>

                <x-text-input name="manufacturer" label="製造元" placeholder="製造元を入力" x-model="formData.manufacturer" />

                <x-text-input name="jan_code" label="JANコード" placeholder="JANコードを入力" x-model="formData.jan_code" />
                <span x-text="errors.jan_code" x-show="errors.jan_code" class="text-sm text-red-600 mb-2 ml-2"></span>

                <x-text-input name="category" label="カテゴリ" placeholder="カテゴリを入力" x-model="formData.category" />

                <x-text-input name="tags" label="タグ" placeholder="タグを入力（カンマ区切り）" x-model="formData.tags" />

                <x-textarea-input name="remarks" label="備考" placeholder="備考を入力" x-model="formData.remarks" />

                <x-radio-input name="public_flg" label="公開フラグ" :options="$publicFlg_codes" x-model="formData.public_flg" />

                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        x-text="messages_jp.ui?.update">
                    </button>
                </div>
            </form>

            <x-modal id="productModal" title="モーダルタイトル">
                <x-slot name="footer">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        閉じる
                    </button>
                </x-slot>
            </x-modal>
        </div>
    </div>

    <script>
        function productForm(product = null) {
            return {
                messages: window.messages_jp || {},
                formData: {
                    product_name: product ? product.product_name : '',
                    price: product ? product.price : 0,
                    product_description: product ? product.product_description : '',
                    product_image: product ? product.product_image : '',
                    manufacturer: product ? product.manufacturer : '',
                    jan_code: product ? product.jan_code : '',
                    category: product ? product.category : '',
                    tags: product ? product.tags : '',
                    remarks: product ? product.remarks : '',
                    store_id: product ? product.store_id : 0,
                    public_flg: product ? product.public_flg : 0
                },
                message: {
                    text: '',
                    type: ''
                },
                imageFile: {
                    fileName: '',
                    imageUrl: product ? '{{ asset('storage') }}/' + product.product_image : null
                },
                show: false,
                errors: {},
                formRules: {
                    product_name: [validationRules.required],
                    price: [validationRules.required, validationRules.integer]
                },
                validateField(field) {
                    this.errors[field] = validateField(this.formData[field], this.formRules[field]);
                },
                validateForm() {
                    this.errors = validateForm(this.formData, this.formRules);
                },
                get isFormValid() {
                    return Object.values(this.errors).every(error => !error);
                },
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.type.startsWith('image/')) {
                            this.imageFile.fileName = file.name;
                            this.imageFile.imageUrl = URL.createObjectURL(file);
                            // Clear the existing image URL when a new file is selected
                            this.formData.product_image = null;
                        } else {
                            console.log('no file');
                            this.errors['product_image'] = messages_jp.msg.image_only;
                            this.resetFileInput();
                        }
                    }
                },
                async submitForm() {
                    this.validateForm();
                    if (this.isFormValid) {
                        let formData = new FormData();
                        
                        // Append all form data
                        for (let key in this.formData) {
                            // Skip appending product_image if it's null and no new file is uploaded
                            if (key === 'product_image' && !this.formData[key]) {
                                continue;
                            }
                            formData.append(key, this.formData[key]);
                        }

                        // Append the file if a new one is selected
                        if (this.$refs.fileInput.files.length > 0) {
                            formData.append('product_image', this.$refs.fileInput.files[0]);
                        }

                        try {
                            const response = await axios.post('/products/update/' + (product ? product.id : ''), formData, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            });

                            this.message = {
                                text: response.data.message,
                                type: 'success'
                            };
                            this.show = true;
                        } catch (error) {
                            console.log('Error:', error);
                            if (error.response && error.response.data.errors) {
                                this.errors = error.response.data.errors;
                            }
                        }
                    } else {
                        this.show = true;
                        this.message = {
                            text: this.messages['validation_error'] || 'バリデーションエラー',
                            type: 'danger'
                        };
                    }
                },
                resetFileInput() {
                    this.$refs.fileInput.value = '';
                    this.imageFile.fileName = '';
                    this.imageFile.imageUrl = this.formData.product_image ? '{{ asset('storage') }}/' + this.formData.product_image : null;
                },
            }
        }
    </script>
@endsection
