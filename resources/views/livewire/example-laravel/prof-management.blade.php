<!DOCTYPE html>
<html>
<head>
    <title>Laravel AJAX Professeurs Management</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .imgUpload {
            max-width: 90px;
            max-height: 70px;
            min-width: 50px;
            min-height: 50px;
        }
        .required::after {
            content: " *";
            color: red;
        }
        .modal-content {
            max-width: 800px;
            margin: 0 auto;
        }
        .form-control {
            border: 1px solid #ccc;
        }
        .form-control:focus {
            border-color: #66afe9;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                <div class="alert alert-success fade-out">
                    {{ session('status')}}
                </div>
                @endif
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#profAddModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Ajouter 
                            </button>
                            <a href="#" class="btn btn-success">Exporter</a>
                        </div>
                        <form action="/search4" method="get" class="d-flex align-items-center ms-auto">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search4" id="search_bar" class="form-control" placeholder="Rechercher..." value="{{ isset($search4) ? $search4 : ''}}">
                            </div>
                            <div id="search_list"></div>
                        </form>
                    </div>
                    <div class="me-3 my-3 text-end"></div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0" id="professors-table">
                            @include('livewire.example-laravel.professeur-list', ['profs' => $profs])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->

    <!-- Add Student Modal -->
        <!-- Add Prof Modal -->
        
    <!-- Add Prof Modal -->
    <div class="modal fade" id="profAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 40cm;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouvel Professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="prof-add-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="form-control" id="new-prof-image" name="image">
                            </div>
                            <div class="col-md-3">
                                <label for="nomprenom" class="form-label required">Nom & Prénom:</label>
                                <input type="text" class="form-control" id="new-prof-nomprenom" placeholder="Nom & Prénom" name="nomprenom">
                                <div class="text-danger" id="nomprenom-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="diplome" class="form-label">Diplôme:</label>
                                <input type="text" class="form-control" id="new-prof-diplome" placeholder="Diplôme" name="diplome">
                            </div>
                            <div class="col-md-3">
                                <label for="lieunaissance" class="form-label">Lieu de naissance:</label>
                                <input type="text" class="form-control" id="new-prof-lieunaissance" placeholder="Lieu de naissance" name="lieunaissance">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-3">
                                <label for="country_id" class="form-label required">Nationalité</label>
                                <select class="form-control" id="new-prof-country_id" name="country_id">
                                    <option value="">Choisir la nationalité</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="country_id-warning"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="type_id" class="form-label required">Type de contrat</label>
                                <select class="form-control" id="new-prof-type_id" name="type_id">
                                    <option value="">Choisir le type de contrat</option>
                                    @foreach ($typeymntprofs as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="type_id-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Genre:</label>
                                <div>
                                    <input type="radio" id="male" name="genre" value="Male">
                                    <label for="male">Male</label>
                                    <input type="radio" id="female" name="genre" value="Female">
                                    <label for="female">Female</label>
                                </div>
                                <div class="text-danger" id="genre-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="datenaissance" class="form-label">Date de naissance:</label>
                                <input type="date" class="form-control" id="new-prof-datenaissance" placeholder="Date de naissance" name="datenaissance">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="new-prof-email" placeholder="email@example.com" name="email">
                            </div>
                            <div class="col-md-3">
                                <label for="phone" class="form-label required">Portable:</label>
                                <input type="text" class="form-control" id="new-prof-phone" placeholder="Portable" name="phone">
                                <div class="text-danger" id="phone-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="wtsp" class="form-label">WhatsApp:</label>
                                <input type="text" class="form-control" id="new-prof-wtsp" placeholder="WhatsApp" name="wtsp">
                            </div>
                            <div class="col-md-3">
                                <label for="adress" class="form-label">Adresse:</label>
                                <input type="text" class="form-control" id="new-prof-adress" placeholder="Adresse" name="adress">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="add-new-prof">Ajouter</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Prof Modal -->
    <div class="modal fade" id="profEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 40cm;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="prof-edit-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="prof-id" name="id">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="image" class="form-label">Image:</label>
                                <img src="" id="imagePreview" class="imgUpload" alt="">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="col-md-3">
                                <label for="nomprenom" class="form-label required">Nom & Prénom:</label>
                                <input type="text" class="form-control" id="prof-nomprenom" placeholder="Nom & Prénom" name="nomprenom">
                                <div class="text-danger" id="edit-nomprenom-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="diplome" class="form-label">Diplôme:</label>
                                <input type="text" class="form-control" id="prof-diplome" placeholder="Diplôme"  name="diplome">
                            </div>
                            <div class="col-md-3">
                                <label for="lieunaissance" class="form-label">Lieu de naissance:</label>
                                <input type="text" class="form-control" id="prof-lieunaissance" placeholder="Lieu de naissance" name="lieunaissance">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-3">
                                <label for="country_id" class="form-label required">Nationalité</label>
                                <select class="form-control" id="prof-country_id" name="country_id">
                                    <option value="">Choisir la nationalité</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="edit-country_id-warning"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="type_id" class="form-label required">Type de contrat</label>
                                <select class="form-control" id="prof-type_id" name="type_id">
                                    <option value="">Choisir le type de contrat</option>
                                    @foreach ($typeymntprofs as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="edit-type_id-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Genre:</label>
                                <div>
                                    <input type="radio" id="male" name="genre" value="Male">
                                    <label for="male">Male</label>
                                    <input type="radio" id="female" name="genre" value="Female">
                                    <label for="female">Female</label>
                                </div>
                                <div class="text-danger" id="edit-genre-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="datenaissance" class="form-label">Date de naissance:</label>
                                <input type="date" class="form-control" id="prof-datenaissance" placeholder="Date de naissance" name="datenaissance">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="prof-email" placeholder="email@example.com" name="email">
                            </div>
                            <div class="col-md-3">
                                <label for="phone" class="form-label required">Portable:</label>
                                <input type="text" class="form-control" id="prof-phone" placeholder="Portable" name="phone">
                                <div class="text-danger" id="edit-phone-warning"></div>
                            </div>
                            <div class="col-md-3">
                                <label for="wtsp" class="form-label">WhatsApp:</label>
                                <input type="text" class="form-control" id="prof-wtsp" placeholder="WhatsApp" name="wtsp">
                            </div>
                            <div class="col-md-3">
                                <label for="adress" class="form-label">Adresse:</label>
                                <input type="text" class="form-control" id="prof-adress" placeholder="Adresse" name="adress">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="prof-update">Modifier</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Recherche AJAX
            $('#search_bar').on('keyup', function(){
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('search4') }}",
                    type: "GET",
                    data: {'search': query},
                    success: function(data){
                        $('#professors-table').html(data.html);
                    }
                });
            });

            function validateForm(formSelector, warningSelectors) {
                let isValid = true;
                $(formSelector).find('input, select').each(function() {
                    let input = $(this);
                    let warningSelector = warningSelectors[input.attr('id')];
                    if (warningSelector && input.prop('required') && !input.val()) {
                        $(warningSelector).text('Ce champ est requis.');
                        isValid = false;
                    } else {
                        $(warningSelector).text('');
                    }
                });
                return isValid;
            }


            $("#add-new-prof").click(function(e){
                e.preventDefault();
                if (!validateForm('#prof-add-form', {
                    'new-prof-nomprenom': '#nomprenom-warning',
                    'new-prof-country_id': '#country_id-warning',
                    'new-prof-type_id': '#type_id-warning',
                    'new-prof-genre': '#genre-warning',
                    'new-prof-phone': '#phone-warning'
                })) {
                    return;
                }
                let form = $('#prof-add-form')[0];
                let data = new FormData(form);

                $.ajax({
    url: "{{ route('prof.store') }}",
    type: "POST",
    data: data,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.errors) {
            let errorMsg = '';
            $.each(response.errors, function(field, errors) {
                $.each(errors, function(index, error) {
                    errorMsg += error + '<br>';
                });
            });
            iziToast.error({
                message: errorMsg,
                position: 'topRight'
            });
        } else {
            iziToast.success({
                message: response.success,
                position: 'topRight'
            });
            $('#profAddModal').modal('hide');
            setTimeout(function () {
                location.reload();
            }, 1000);
            addStudentToTable(response.prof);
        }
    },
    error: function(xhr, status, error) {
        let errorMsg = '';
        if (xhr.responseJSON && xhr.responseJSON.errors) {
            $.each(xhr.responseJSON.errors, function(field, errors) {
                $.each(errors, function(index, error) {
                    errorMsg += error + '<br>';
                });
            });
        } else {
            errorMsg = 'An error occurred: ' + error;
        }
        iziToast.error({
            message: errorMsg,
            position: 'topRight'
        });
    }
});

            });

            $('body').on('click', '#edit-prof', function () {
                var tr = $(this).closest('tr');
                $('#prof-id').val($(this).data('id'));
                $('#prof-nomprenom').val(tr.find("td:nth-child(3)").text());
                $('#prof-type_id').val(tr.find("td:nth-child(4)").data('type-id'));
                $('#prof-country_id').val(tr.find("td:nth-child(5)").data('country-id'));
                $('#prof-diplome').val(tr.find("td:nth-child(6)").text());
                var genre = tr.find("td:nth-child(7)").text();
                $('input[name="genre"][value="' + genre + '"]').prop('checked', true);
                $('#prof-lieunaissance').val(tr.find("td:nth-child(8)").text());
                $('#prof-adress').val(tr.find("td:nth-child(9)").text());
                $('#prof-datenaissance').val(tr.find("td:nth-child(10)").text());
                $('#prof-email').val(tr.find("td:nth-child(11)").text());
                $('#prof-phone').val(tr.find("td:nth-child(12)").text());
                $('#prof-wtsp').val(tr.find("td:nth-child(13)").text());
                $('#imagePreview').attr('src', tr.find("td:nth-child(2) img").attr('src'));

                $('#profEditModal').modal('show');
            });

            $('body').on('click', '#prof-update', function () {
                if (!validateForm('#prof-edit-form', {
                    'prof-nomprenom': '#edit-nomprenom-warning',
                    'prof-country_id': '#edit-country_id-warning',
                    'prof-type_id': '#edit-type_id-warning',
                    'prof-phone': '#edit-phone-warning'
                })) {
                    return;
                }
                var id = $('#prof-id').val();
                var formData = new FormData($('#prof-edit-form')[0]);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: "{{ route('prof.update', '') }}/" + id,
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#profEditModal').modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        if (response.success) {
                            iziToast.success({
                                message: response.success,
                                position: 'topRight'
                            });
                            updateStudentInTable(response.prof);
                        } else {
                            iziToast.error({
                                message: response.error,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMsg = '';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(field, errors) {
                                $.each(errors, function(index, error) {
                                    errorMsg += error + '<br>';
                                });
                            });
                        } else {
                            errorMsg = 'An error occurred: ' + error;
                        }
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                    }
                });
            });

            function addStudentToTable(prof) {
                var newRow = `<tr id="student-${prof.id}">
                    <td>${prof.id}</td>
                    <td><img src="{{ asset('images/') }}/${prof.image}" alt="" width="60px"></td>
                    <td>${prof.nomprenom}</td>
                    <td data-type-id="${prof.type_id}">${prof.type ? prof.type.type : 'N/A'}</td>
                    <td data-country-id="${prof.country_id}">${prof.country ? prof.country.name : 'N/A'}</td>
                    <td>${prof.diplome}</td>
                    <td>${prof.genre}</td>
                    <td>${prof.lieunaissance}</td>
                    <td>${prof.adress}</td>
                    <td>${prof.datenaissance}</td>
                    <td>${prof.email}</td>
                    <td>${prof.phone}</td>
                    <td>${prof.wtsp}</td>
                    <td>
                        <a href="javascript:void(0)" id="edit-prof" data-id="${prof.id}" class="btn btn-info"><i class="material-icons opacity-10">border_color</i></a>
                        <a href="javascript:void(0)" id="delete-prof" data-id="${prof.id}" class="btn btn-danger"><i class="material-icons opacity-10">delete</i></a>
                    </td>
                </tr>`;
                $('table tbody').append(newRow);
            }

            function updateStudentInTable(prof) {
                var row = $('#student-' + prof.id);
                row.find('td:nth-child(2) img').attr('src', '{{ asset("images") }}/' + prof.image);
                row.find('td:nth-child(3)').text(prof.nomprenom);
                row.find('td:nth-child(4)').text(prof.type ? prof.type.type : 'N/A').attr('data-type-id', prof.type_id);
                row.find('td:nth-child(5)').text(prof.country ? prof.country.name : 'N/A').attr('data-country-id', prof.country_id);
                row.find('td:nth-child(6)').text(prof.diplome);
                row.find('td:nth-child(7)').text(prof.genre);
                row.find('td:nth-child(8)').text(prof.lieunaissance);
                row.find('td:nth-child(9)').text(prof.adress);
                row.find('td:nth-child(10)').text(prof.datenaissance);
                row.find('td:nth-child(11)').text(prof.email);
                row.find('td:nth-child(12)').text(prof.phone);
                row.find('td:nth-child(13)').text(prof.wtsp);
            }

            // Delete prof
            $('body').on('click', '#delete-prof', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?");
                if (confirmation) {
                    $.ajax({
                        url: "{{ route('prof.delete', '') }}/" + id,
                        type: 'DELETE',
                        success: function(response) {
                            iziToast.success({
                                message: response.success,
                                position: 'topRight'
                            });
                            removeStudentFromTable(id);
                        },
                        error: function(xhr, status, error) {
                            iziToast.error({
                                message: 'An error occurred: ' + error,
                                position: 'topRight'
                            });
                        }
                    });
                }
            });

            function removeStudentFromTable(id) {
                $(`#student-${id}`).remove();
            }

            var alertElement = document.querySelector('.fade-out');
            if (alertElement) {
                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 2000);
            }
        });
    </script>

</body>
</html>