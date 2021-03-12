@extends('layout')
@section('content')

<div class="container bootdey flex-grow-1 container-p-y">

            <div class="media align-items-center py-3 mb-3">
                <x-avatar width='140' height='140' :src='$user->image->path??null'></x-avatar>
                <div class="media-body ml-4">
                <h4 class="font-weight-bold mb-0">{{ $user->name }} <span class="text-muted font-weight-normal">@johndoe</span></h4>
                <div class="text-muted mb-2">{{ $user->id }}</div>
                <a href="{{ route('users.edit',['user'=>$user]) }}" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                <a href="#" class="btn btn-default btn-sm">Profile</a>&nbsp;
                <a href="#" class="btn btn-default btn-sm icon-btn"><i class="fa fa-mail"></i></a>
              </div>
            </div>

            {{-- <div class="card mb-4">
              <div class="card-body">
                 <table class="table user-view-table m-0">
                  <tbody>
                    <tr>
                      <td>Registered:</td>
                      <td>01/23/2017</td>
                    </tr>
                    <tr>
                      <td>Latest activity:</td>
                      <td>01/23/2018 (14 days ago)</td>
                    </tr>
                    <tr>
                      <td>Verified:</td>
                      <td><span class="fa fa-check text-primary"></span>&nbsp; Yes</td>
                    </tr>
                    <tr>
                      <td>Role:</td>
                      <td>User</td>
                    </tr>
                    <tr>
                      <td>Status:</td>
                      <td><span class="badge badge-outline-success">Active</span></td>
                    </tr>
                  </tbody>
                </table>
              </div> --}}
              {{-- <hr class="border-light m-0"> --}}
              {{--<div class="table-responsive">
                <table class="table card-table m-0">
                  <tbody>
                    <tr>
                      <th>Module Permission</th>
                      <th>Read</th>
                      <th>Write</th>
                      <th>Create</th>
                      <th>Delete</th>
                    </tr>
                    <tr>
                      <td>Users</td>
                      <td><span class="fa fa-check text-primary"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                    </tr>
                    <tr>
                      <td>Articles</td>
                      <td><span class="fa fa-check text-primary"></span></td>
                      <td><span class="fa fa-check text-primary"></span></td>
                      <td><span class="fa fa-check text-primary"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                    </tr>
                    <tr>
                      <td>Staff</td>
                      <td><span class="fa fa-times text-light"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                      <td><span class="fa fa-times text-light"></span></td>
                    </tr>
                  </tbody>
                </table> --}}
              {{-- </div> --}}
            {{-- </div> --}}

            <div class="card">
              <div class="row no-gutters row-bordered">
                <div class="d-flex col-md align-items-center">
                  <a href="{{ route('posts.myPost') }}" class="card-body d-block text-body ">
                    <div class="text-muted small line-height-1">Posts</div>
                    <div class="text-xlarge "><h4 class="text-warning"">{{ $user->posts->count() }}</h4></div>
                  </a>
                </div>
                <div class="d-flex col-md align-items-center">
                  <a href="javascript:void(0)" class="card-body d-block text-body">
                    <div class="text-muted small line-height-1">Followers</div>
                    <div class="text-xlarge">534</div>
                  </a>
                </div>
                <div class="d-flex col-md align-items-center">
                  <a href="javascript:void(0)" class="card-body d-block text-body">
                    <div class="text-muted small line-height-1">Following</div>
                    <div class="text-xlarge">236</div>
                  </a>
                </div>
              </div>
              <hr class="border-light m-0">
              <div class="card-body">

                <table class="table user-view-table m-0">
                  <tbody>
                    <tr>
                      <td>Username:</td>
                      <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                      <td>Name:</td>
                      <td>Nelle Maxwell</td>
                    </tr>
                    <tr>
                      <td>E-mail:</td>
                      <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                      <td>Company:</td>
                      <td>Company Ltd.</td>
                    </tr>
                  </tbody>
                </table>

                <h6 class="mt-4 mb-3">Social links</h6>

                <table class="table user-view-table m-0">
                  <tbody>
                    <tr>
                      <td>Twitter:</td>
                      <td><a href="javascript:void(0)">https://twitter.com/user</a></td>
                    </tr>
                    <tr>
                      <td>Facebook:</td>
                      <td><a href="javascript:void(0)">https://www.facebook.com/user</a></td>
                    </tr>
                    <tr>
                      <td>Instagram:</td>
                      <td><a href="javascript:void(0)">https://www.instagram.com/user</a></td>
                    </tr>
                  </tbody>
                </table>

                <h6 class="mt-4 mb-3">Personal info</h6>

                <table class="table user-view-table m-0">
                  <tbody>
                    <tr>
                      <td>Birthday:</td>
                      <td>May 3, 1995</td>
                    </tr>
                    <tr>
                      <td>Country:</td>
                      <td>Canada</td>
                    </tr>
                    <tr>
                      <td>Languages:</td>
                      <td>English</td>
                    </tr>
                  </tbody>
                </table>

                <h6 class="mt-4 mb-3">Contacts</h6>

                <table class="table user-view-table m-0">
                  <tbody>
                    <tr>
                      <td>Phone:</td>
                      <td>+0 (123) 456 7891</td>
                    </tr>
                  </tbody>
                </table>

                <h6 class="mt-4 mb-3">Interests</h6>

                <table class="table user-view-table m-0">

                </table>

              </div>
            </div>

          </div>

@endsection
