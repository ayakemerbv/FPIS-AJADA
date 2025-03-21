@extends('layouts.app')

@section('content')

    <div class="flex justify-center items-center min-h-screen" id="request-repair">
        <div class="bg-white shadow-xl rounded-2xl p-6 w-96">
            <h2 class="text-lg font-semibold text-gray-800 text-center">Новый запрос на ремонт</h2>
            <form action="{{ route('request.store') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <label class="block text-sm text-gray-600">Тип проблемы</label>
                    <select name="type" id="type" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option selected disabled>Выберите проблему...</option>
                        <option value="Электрика">Электрика</option>
                        <option value="Водопровод">Водопровод</option>
                        <option value="Другое">Другое</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-sm text-gray-600">Опишите что случилось</label>
                    <textarea class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3" placeholder="Введите описание..." name="description"></textarea>
                </div>

                <div class="mt-4">
                    <input type="file" id="file-upload" class="hidden" name="file">
                    <label  for="file-upload" id="file-label" class="text-sm text-gray-500 cursor-pointer block border-dashed border-2 p-2 rounded-lg text-center">
                        📎 Прикрепить файл (не выбрано)
                    </label>
                </div>



                <div class="mt-4">
                    <label class="block text-sm text-gray-600">Выбрать сотрудника</label>
                    <select class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="employee">
                        <option selected disabled>Выберите сотрудника по проблеме</option>
                        @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="submit" class="bg-green-300 text-gray-800 px-4 py-2 hover:bg-400" style="border-radius: 4px">Отправить</button>
                    <a href="{{route('student.personal')}}"  class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400" style="border-radius: 4px">Отменить</a>
                </div>
            </form>
            </div>


    </div>
    <script>
        document.getElementById("file-upload").addEventListener("change", function () {
            let fileName = this.files[0] ? this.files[0].name : "Не выбрано";
            document.getElementById("file-label").textContent = `📎 ${fileName}`;
        });
    </script>
@endsection
