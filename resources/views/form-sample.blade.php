@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Counter Example</h1>
        <x-counter />
    </div>

    <div x-data="{ icon: 'fa-solid fa-user' }">
        <i :class="icon"></i>
        <button @click="icon = 'fa-solid fa-home'">Change to Home Icon</button>
    </div>

    <!-- FontAwesome CDN 추가 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div x-data="formData()" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-md w-full">
        <!-- textbox -->
        {{-- <div class="mb-4">
            <label :for="formFields.name.id" class="block text-sm font-medium text-gray-700 mb-2" x-text="formFields.name.label"></label>
            <input
                :type="formFields.name.type"
                :id="formFields.name.id"
                x-model="formData.name"
                :placeholder="formFields.name.placeholder"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            >
        </div> --}}

        <x-text-input name="name" label="名前-Component" placeholder="名前を入力" x-model="formData.name" />

        <!-- Radiobox -->
        {{-- <div class="mb-4">
            <span class="block text-sm font-medium text-gray-700 mb-2" x-text="formFields.gender.label"></span>
            <div class="space-y-2">
                <template x-for="option in formFields.gender.options" :key="option.value">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" :name="formFields.gender.id" :value="option.value" x-model="formData.gender" class="w-4 h-4">
                        <span></span>
                        <span class="m-2" x-text="option.label"></span>
                    </label>
                </template>
            </div>
        </div> --}}

        <x-radio-input name="gender" label="性別-Component" :options="[['value' => 'male', 'label' => '男性'], ['value' => 'female', 'label' => '女性']]" x-model="formData.gender" />

        <!-- Checkbox -->
        {{-- <div class="mb-4">
            <span class="block text-sm font-medium text-gray-700 mb-2" x-text="formFields.interests.label"></span>
            <div class="space-y-2">
                <template x-for="option in formFields.interests.options" :key="option.value">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="option.value" x-model="formData.interests" class="w-4 h-4">
                        <span></span>
                        <span class="m-2" x-text="option.label"></span>
                    </label>
                </template>
            </div>
        </div> --}}

        <x-checkbox-input name="interests" label="興味のある分野-Component" :options="[
            ['value' => 'technology', 'label' => '技術'],
            ['value' => 'art', 'label' => '芸術'],
            ['value' => 'sports', 'label' => 'スポーツ'],
        ]" x-model="formData.interests" />

        <!-- セレクトボックス -->
        {{-- <div class="mb-4">
            <label :for="formFields.country.id" class="block text-sm font-medium text-gray-700 mb-2" x-text="formFields.country.label"></label>
            <select
                :id="formFields.country.id"
                x-model="formData.country"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            >
                <option value="" x-text="formFields.country.placeholder"></option>
                <template x-for="option in formFields.country.options" :key="option.value">
                    <option :value="option.value" x-text="option.label"></option>
                </template>
            </select>
        </div> --}}

        <x-select-input name="country" label="国-Component" placeholder="選択してください" :options="[
            ['value' => 'japan', 'label' => '日本'],
            ['value' => 'usa', 'label' => 'アメリカ'],
            ['value' => 'uk', 'label' => 'イギリス'],
            ['value' => 'australia', 'label' => 'オーストラリア'],
        ]"
            x-model="formData.country" />

        <x-date-picker name="birthday" label="誕生日-Component" placeholder="誕生日を選択" x-model="formData.birthday" />

        <!-- 送信ボタン -->
        <button @click="submitForm"
            class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600"
            x-text="submitButtonText">
        </button>
    </div>

    <div x-data="imageFileInput()" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-md w-full">
        <label class="block text-sm font-medium text-gray-700 mb-2">画像ファイルを選択</label>
        <div class="mt-1 flex items-center">
            <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                <template x-if="imageUrl">
                    <img :src="imageUrl" alt="Selected" class="h-full w-full object-cover">
                </template>
                <template x-if="!imageUrl">
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </template>
            </span>
            <input type="file" accept="image/*" @change="handleFileChange" class="hidden" x-ref="fileInput">
            <button type="button" @click="$refs.fileInput.click()"
                class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                ファイルを選択
            </button>
            <button x-show="fileName" @click="clearFile" type="button" placeholder="日付を選択"
                class="ml-2 bg-red-100 py-2 px-3 border border-red-300 rounded-md shadow-sm text-sm leading-4 font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                ✕
            </button>
        </div>
        <div x-show="fileName" class="mt-2 text-sm text-gray-500" x-text="fileName"></div>
        <div x-show="fileError" class="mt-2 text-sm text-red-600" x-text="fileError"></div>
    </div>

    <div x-data="japaneseDatePicker()" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-sm w-full">
        <div class="flex items-center space-x-4">
            <input type="text" x-ref="input" placeholder="日付を選択"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button @click="clearDate"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600">✕</button>
        </div>
    </div>

    <div x-data="timePicker()" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-sm w-full">
        <div class="flex items-center space-x-4">
            <input type="text" x-ref="input" placeholder="時間を選択"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button @click="clearTime"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600">✕</button>
        </div>
    </div>

    <div x-data="japaneseDateTimePicker()" class="bg-white shadow-md rounded-lg p-6 m-4 max-w-sm w-full">
        <div class="flex items-center space-x-4">
            <input type="text" x-ref="input" placeholder="日付と時間を選択"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <button @click="clearDateTime"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600">✕</button>
        </div>
    </div>

    {{-- モーダルコンポーネントの呼び出し --}}
    <div>
        <button type="button" @click="$dispatch('open-modal', { content: 'モーダルコンポーネントです。' })"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            モーダルコンポーネント
        </button>
    </div>
    <x-modal id="productModal" title="タイトル">
        <x-slot name="footer">
            <button type="button" @click="$dispatch('close-modal')"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                閉じる
            </button>
        </x-slot>
    </x-modal>

    <div x-data="tabulatorData()" x-init="initTable">
        <div class="w-full bg-white shadow-md rounded-lg overflow-hidden my-4">
            <div class="p-3 sm:px-4 flex justify-between items-center bg-gray-50">
              <h2 class="text-lg font-semibold text-blue-600"><i class="fas fa-search"></i>検索条件</h2>
              <button @click="isOpen = !isOpen" class="text-indigo-600 hover:text-indigo-500 focus:outline-none">
                <i x-show="isOpen" class="fas fa-chevron-up"></i>
                <i x-show="!isOpen" class="fas fa-chevron-down"></i>
              </button>
            </div>

            <div x-show="isOpen" x-transition class="px-4 py-1">
              <div class="space-y-4">
                <div class="flex flex-wrap items-center space-x-4">
                  <div class="flex-1 min-w-0 sm:flex sm:items-center sm:space-x-4">
                    <div class="w-full sm:w-1/4">
                        <x-text-input name="name" label="名前" placeholder="名前を入力" x-model="formData.name" />
                    </div>
                    <div class="w-full sm:w-1/4">
                        <x-text-input name="address" label="住所" placeholder="住所を入力" x-model="formData.address" />
                    </div>
                    <div class="w-full sm:w-1/4">
                        <x-text-input name="birthday" label="誕生日" placeholder="誕生日を入力" x-model="formData.birthday" />
                      </div>
                    <div class="w-full sm:w-1/4">
                        <x-radio-input name="gender" label="性別" :options="[['value' => '0', 'label' => '男性'], ['value' => '1', 'label' => '女性']]" x-model="formData.gender" />
                    </div>
                  </div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                  <button @click="clearSearch" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                    <i class="fas fa-eraser mr-2"></i>条件クリア
                  </button>
                  <button @click="search" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <i class="fas fa-search mr-2"></i>検索開始
                  </button>
                </div>
              </div>
            </div>
          </div>

        <div id="example-table"></div>
    </div>

    <script>
        function formData() {
            return {
                formFields: {
                    name: {
                        id: 'name',
                        type: 'text',
                        label: '名前',
                        placeholder: '名前を入力'
                    },
                    gender: {
                        id: 'gender',
                        label: '性別',
                        options: [{
                                value: 'male',
                                label: '男性'
                            },
                            {
                                value: 'female',
                                label: '女性'
                            }
                        ]
                    },
                    interests: {
                        id: 'interests',
                        label: '興味のある分野',
                        options: [{
                                value: 'technology',
                                label: '技術'
                            },
                            {
                                value: 'art',
                                label: '芸術'
                            },
                            {
                                value: 'sports',
                                label: 'スポーツ'
                            }
                        ]
                    },
                    country: {
                        id: 'country',
                        label: '国',
                        placeholder: '選択してください',
                        options: [{
                                value: 'japan',
                                label: '日本'
                            },
                            {
                                value: 'usa',
                                label: 'アメリカ'
                            },
                            {
                                value: 'uk',
                                label: 'イギリス'
                            },
                            {
                                value: 'australia',
                                label: 'オーストラリア'
                            }
                        ]
                    }
                },
                formData: {
                    name: '',
                    gender: 'male',
                    interests: ["art"],
                    country: '',
                    birthday: ''
                },
                submitButtonText: '送信',
                submitForm() {
                    console.log('Form submitted', this.formData);
                    // ここにフォーム送信のロジックを追加
                }
            }
        }

        function imageFileInput() {
            return {
                fileName: '',
                fileError: '',
                imageUrl: null,
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.type.startsWith('image/')) {
                            this.fileName = file.name;
                            this.fileError = '';
                            this.imageUrl = URL.createObjectURL(file);
                        } else {
                            this.fileError = '画像ファイルのみ選択可能です。';
                            this.fileName = '';
                            this.imageUrl = null;
                            event.target.value = ''; // ファイル選択をリセット
                        }
                    }
                },
                clearFile() {
                    this.fileName = '';
                    this.fileError = '';
                    this.imageUrl = null;
                    this.$refs.fileInput.value = ''; // ファイル選択をリセット
                }
            }
        }

        function japaneseDatePicker() {
            return {
                selectedDate: '',
                flatpickrInstance: null,
                init() {
                    this.flatpickrInstance = flatpickr(this.$refs.input, {
                        locale: window.FlatpickrJapanese, // 日本語化
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.selectedDate = dateStr;
                        }
                    });
                },
                clearDate() {
                    this.flatpickrInstance.clear();
                    this.selectedDate = '';
                }
            }
        }

        function japaneseDateTimePicker() {
            return {
                selectedDateTime: '',
                flatpickrInstance: null,
                init() {
                    this.flatpickrInstance = flatpickr(this.$refs.input, {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        time_24hr: true,
                        locale: window.FlatpickrJapanese, // 日本語化
                        onChange: (selectedDates, dateStr) => {
                            this.selectedDateTime = dateStr;
                        }
                    });
                },
                clearDateTime() {
                    this.flatpickrInstance.clear();
                    this.selectedDateTime = '';
                }
            }
        }

        function timePicker() {
            return {
                selectedTime: '',
                flatpickrInstance: null,
                init() {
                    this.flatpickrInstance = flatpickr(this.$refs.input, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        onChange: (selectedDates, dateStr) => {
                            this.selectedTime = dateStr;
                        }
                    });
                },
                clearTime() {
                    this.flatpickrInstance.clear();
                    this.selectedTime = '';
                }
            }
        }

        function tabulatorData() {
            return {
                formData: {
                    name: '',
                    address: '',
                    birthday: '',
                    gender: '0',
                },
                isOpen: true,
                tableData: [{
                        id: 1,
                        name: "Oli Bob",
                        age: 12,
                        col: "red",
                        dob: "2010-01-01"
                    },
                    {
                        id: 2,
                        name: "Mary May",
                        age: 1,
                        col: "blue",
                        dob: "1982-05-14"
                    },
                    {
                        id: 3,
                        name: "Christine Lobowski",
                        age: 42,
                        col: "blue",
                        dob: "1982-05-22"
                    },
                    {
                        id: 4,
                        name: "Brendon Philips",
                        age: 125,
                        col: "blue",
                        dob: "1980-08-01"
                    },
                    {
                        id: 5,
                        name: "Margret Marmajuke",
                        age: 16,
                        col: "blue",
                        dob: "1999-01-31"
                    },
                    {
                        id: 6,
                        name: "John Doe",
                        age: 30,
                        col: "red",
                        dob: "1993-06-15"
                    },
                    {
                        id: 7,
                        name: "Jane Smith",
                        age: 28,
                        col: "blue",
                        dob: "1995-08-22"
                    },
                    {
                        id: 8,
                        name: "Tom Johnson",
                        age: 45,
                        col: "red",
                        dob: "1978-11-30"
                    },
                    {
                        id: 9,
                        name: "Emily Brown",
                        age: 22,
                        col: "blue",
                        dob: "2001-03-12"
                    },
                    {
                        id: 10,
                        name: "Michael Davis",
                        age: 35,
                        col: "red",
                        dob: "1988-09-05"
                    },
                ],
                table: null,
                initTable() {
                    //Generate print icon
                    const editIcon = (cell, formatterParams) => "<i class=\"fa-solid fa-pen-to-square\"></i>";
                    const editClickEvent = (e, cell) => {
                        alert("EDIT ID: " + cell.getRow().getData().id);
                        console.dir(cell.getRow().getData());
                    }

                    const deleteIcon = (cell, formatterParams) => "<i class=\"fa-solid fa-trash\"></i>";
                    const deleteClickEvent = (e, cell) => {
                        alert("EDELETE ID: " + cell.getRow().getData().id);
                        console.dir(cell.getRow().getData());
                    }

                    this.table = new Tabulator("#example-table", {
                        data: this.tableData,
                        layout: "fitColumns",
                        height: "311px",
                        pagination: true,
                        paginationSize: 5,
                        paginationSizeSelector: [5, 10, 20, 50, 100],
                        // frozenRows:1,
                        columns: [{
                                title: "#",
                                formatter: function(cell, formatterParams, onRendered) {
                                    var row = cell.getRow();
                                    var table = cell.getTable();
                                    var page = table.getPage();
                                    var pageSize = table.getPageSize();
                                    var rowIndex = (page - 1) * pageSize + row.getPosition(true);
                                    return rowIndex;
                                },
                                headerSort: false,
                                width: 60,
                                hozAlign: "center"
                            },
                            {
                                formatter: editIcon,
                                width: 40,
                                hozAlign: "center",
                                headerSort: false,
                                cellClick: editClickEvent
                            },
                            {
                                formatter: deleteIcon,
                                width: 40,
                                hozAlign: "center",
                                headerSort: false,
                                cellClick: deleteClickEvent
                            },
                            {
                                title: "名前",
                                field: "name",
                                editor: "input",
                                sorter: "string",
                                headerFilter: "input"
                            },
                            {
                                title: "歳",
                                field: "age",
                                editor: "number",
                                sorter: "number",
                                headerFilter: "number"
                            },
                            {
                                title: "好きな色",
                                field: "col",
                                editor: "list",
                                editorParams: {
                                    values: {
                                        "red": "red",
                                        "blue": "blue"
                                    }
                                },
                                headerFilter: true,
                                headerFilterParams: {
                                    values: {
                                        "red": "red",
                                        "blue": "blue",
                                        "": ""
                                    },
                                    clearable: true
                                }
                            },
                            {
                                title: "生年月日",
                                field: "dob",
                                editor: "date",
                                headerFilter: "input"
                            },
                        ],
                        initialSort: [{
                            column: "id",
                            dir: "asc"
                        }],
                        locale: true,
                        langs: {
                            "ja-jp": {
                                "pagination": {
                                    "first": "最初",
                                    "first_title": "最初のページ",
                                    "last": "最後",
                                    "last_title": "最後のページ",
                                    "prev": "前",
                                    "prev_title": "前のページ",
                                    "next": "次",
                                    "next_title": "次のページ",
                                    "all": "全て",
                                    "page_size": "表示件数",
                                },
                            }
                        }
                    });

                    // ソートイベントリスナー
                    this.table.on("sortChanged", function() {
                        console.log("ソートされました。");
                    });

                    // フィルターイベントリスナー
                    this.table.on("dataFiltered", function(filters, rows) {
                        console.log("フィルターされました。", filters);
                    });
                },
                // 検索条件クリア
                clearSearch() {
                    this.formData.name = '';
                    this.formData.address = '';
                    this.formData.birthday = '';
                    this.formData.gender = '0';
                },
                //検索処理
                search() {
                    console.log('Search submitted', this.formData);
                    // ここに検索のロジックを追加
                }
            }
        }
    </script>
@endsection
