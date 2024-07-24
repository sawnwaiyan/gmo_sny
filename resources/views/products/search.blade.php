@extends('layouts.app')

@section('content')
    <div class="container">
        <div x-data="productSearch()" class="bg-white shadow-md rounded-lg p-6 m-4 w-full">
            <form @submit.prevent="searchProducts">
                <div class="w-full bg-white shadow-md rounded-lg overflow-hidden my-4">
                    <div class="p-3 sm:px-4 flex justify-between items-center bg-gray-50">
                        <h2 class="text-lg font-semibold text-blue-600"><i class="fas fa-search"></i>検索条件</h2>
                        <button @click="isOpen = !isOpen" class="text-indigo-600 hover:text-indigo-500 focus:outline-none">
                            <i x-show="isOpen" class="fas fa-chevron-up"></i>
                            <i x-show="!isOpen" class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    <div x-show="isOpen" x-transition class="px-4 py-1" x-data="{ isOpen: true }">
                        <div class="space-y-4">
                            <div class="flex flex-wrap items-center space-x-4">
                                <div class="flex-1 min-w-0 sm:flex sm:items-center sm:space-x-4">
                                    <div class="w-full sm:w-1/3">
                                        <x-text-input name="keyword" label="キーワード" placeholder="キーワードを入力" x-model="formData.keyword" />
                                    </div>
                                    <div class="w-full sm:w-1/3">
                                        <x-text-input name="category" label="カテゴリ" placeholder="カテゴリを入力" x-model="formData.category" />
                                    </div>
                                    <div class="w-full sm:w-1/3">
                                        <x-text-input name="manufacturer" label="製造元" placeholder="製造元を入力" x-model="formData.manufacturer" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 mt-6">
                                <button type="button" @click="clearSearch" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                                    <i class="fas fa-eraser mr-2"></i>条件クリア
                                </button>
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    <i class="fas fa-search mr-2"></i>検索開始
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div x-show="showMessage" class="mt-4 p-4 border-l-4"
                :class="{
                    'bg-blue-100 border-blue-500 text-blue-700': message.type === 'info',
                    'bg-green-100 border-green-500 text-green-700': message.type === 'success',
                    'bg-yellow-100 border-yellow-500 text-yellow-700': message.type === 'warning',
                    'bg-red-100 border-red-500 text-red-700': message.type === 'danger'
                }">
                <div class="flex justify-between items-center">
                    <span x-text="message.text"></span>
                    <button @click="showMessage = false" class="text-xl font-bold">&times;</button>
                </div>
            </div>

            <div x-show="showResults" class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-b border-gray-200">商品名</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-b border-gray-200">カテゴリ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-b border-gray-200">製造元</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-b border-gray-200">価格</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-b border-gray-200">操作</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="product in products" :key="product.id">
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200" x-text="product.product_name"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200" x-text="product.category"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200" x-text="product.manufacturer"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200" x-text="product.price"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                    <button @click="editProduct(product.id)" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteProduct(product.id)" class="text-red-500 hover:text-red-700 ml-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function productSearch() {
            return {
                formData: {
                    keyword: '',
                    category: '',
                    manufacturer: ''
                },
                products: [],
                showMessage: true,
                showResults: false,
                isOpen: true,
                message: {
                    text: 'データがありません。',
                    type: 'info'
                },
                async searchProducts() {
                    this.showMessage = false;
                    this.showResults = false;

                    try {
                        const response = await axios.get('/products/search-results', {
                            params: this.formData
                        });

                        this.products = response.data;

                        if (this.products.length > 0) {
                            this.showResults = true;
                        } else {
                            this.message = { text: '結果が見つかりません。', type: 'info' };
                            this.showMessage = true;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.message = { text: '検索中にエラーが発生しました。', type: 'danger' };
                        this.showMessage = true;
                    }
                },
                clearSearch() {
                    this.formData.keyword = '';
                    this.formData.category = '';
                    this.formData.manufacturer = '';
                },
                editProduct(productId) {
                    // Implement your edit logic here
                    window.location.href = `/products/${productId}/edit`;

                },
                deleteProduct(productId) {
                    // Implement your delete logic here
                    console.log('Delete product with ID:', productId);
                }
            }
        }
    </script>
@endsection
