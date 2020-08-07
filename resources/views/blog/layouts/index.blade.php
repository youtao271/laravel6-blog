@extends('blog.layouts.master')

@section('page-header')
    <header class="masthead" style="background-image: url('/storage/uploads/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>{{ $title }}</h1>
                        <span class="subheading">{{ $subtitle }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div id="app">
                <post-list :list="list"></post-list>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="module">
    new Vue({
        el: '#app',
        data(){
            return {
                list: []
            }
        },
        created(){
            axios.get('{{ route('api.posts') }}')
            .then((ret)=>{
                this.list = ret.data.posts.data
                console.log(this.list);
            })
        }
    })

</script>
@endsection
