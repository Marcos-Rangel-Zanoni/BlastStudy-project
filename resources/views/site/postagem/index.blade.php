@auth
    @include('layouts.layout')
@endauth
<div class="carousel-postagem">
    <div id="album-rotator">
        <div id="album-rotator-holder">
            @foreach ($allUsers as $allUser)
                @if ($allUser->id == Auth::user()->id)
                    @continue
                @endif
                <a target="_top" class="album-item" href="#">
                    <span class="album-details">
                        <span class="title">{{ $allUser->name }}</span>

                        <div class="user-short-background">
                            <div class="user-img-short">
                                <img src="{{ $allUser->image }}" alt="Minha Imagem">
                            </div>
                        </div>
                        <div class="user-short"></div>
                        <div class="user-moldura-short">
                            <p class="">{{ $allUser->level }}</p>
                        </div>
                        <div class="user-moldura-short-img">
                            <img src="{{ asset('img/moldura.png') }}" alt="Minha Imagem">
                        </div>
                        <span class="subtext">Follow</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    ($(document).ready(function() {
        // Faz uma requisição AJAX para buscar os usuários no banco de dados do Laravel
        // const perfil_user = "/perfil/name" + item.id+ "";
        $.ajax({
            url: '/index', // Substitua pela URL correta da sua rota Laravel
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var usuarios = response.usuarios;

                    // Itera sobre cada usuário retornado e cria o album-item correspondente
                    for (var i = 0; i < usuarios.length; i++) {
                        var usuario = usuarios[i];

                        // Cria o elemento album-item
                        var albumItem = $('<a/>', {
                            class: 'album-item',
                            href: '#'
                        });

                        // Cria o elemento album-details
                        var albumDetails = $('<span/>', {
                            class: 'album-details'
                        });

                        // Adiciona o nome do usuário como título
                        var title = $('<span/>', {
                            class: 'title',
                            text: usuario.nome
                        });
                        albumDetails.append(title);

                        // Adiciona o nível do usuário como subtítulo
                        var subtitle = $('<span/>', {
                            class: 'subtitle',
                            text: 'Level: ' + usuario.level
                        });
                        albumDetails.append(subtitle);

                        albumItem.append(albumDetails);

                        // Adiciona o album-item criado ao album-rotator-holder
                        $('#album-rotator-holder').append(albumItem);
                    }
                } else {
                    console.log(response.message); // Exibe a mensagem de erro, se houver
                }
            },
            error: function(xhr, status, error) {
                console.log(error); // Exibe o erro ocorrido na requisição AJAX
            }
        });
    }))
</script>
@include('site.postagem.create')



<div class="user-post">
</div>
<div id="post">
    <!-- As postagens serão exibidas aqui -->

</div>
</div>


<script>
    $(window).on('load', function() {
        const addStoreUrl = '/postagem/store';
        const addPullDb = '/postagem/pullAdd';
        const userEndpoint = '/postagem/buscarUsuarios';
        const formPost = $('#form-post');
        const dadosReset = $('#dadosReset');
        const pullContainer = $('#post');
        const userContainer = $('#user-info');

        formPost.on('submit', function(e) {
            e.preventDefault();
            const dadosForm = new FormData(this);
            envBd(dadosForm);
            formPost.each(function() {
                this.reset();
            });
        });

        function envBd(dadosForm) {
            $.ajax({
                    url: addStoreUrl,
                    type: 'POST',
                    data: dadosForm,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                })
                .done(function(response) {
                    console.log("Success");
                    loadForm();
                })
                .fail(function(error, status) {
                    console.log("Error");
                });
        }

        function loadForm() {
            $.ajax({
                    url: addPullDb,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    console.log('Entrou e carregou os dados');
                    displayPosts(data);
                    loadUserInfo(); // Carrega as informações do usuário
                })
                .fail(function(xhr, status, error) {
                    console.error('Erro ao carregar dados', error);
                });
        }

        function displayPosts(data) {
            pullContainer.empty();

            if (data.length === 0) {
                console.log('Não há comentários');
            } else {
                data.reverse().forEach(function(item) {
                    const pull = $('<div>').addClass('pull');
                    const pullHeader = $('<div>').addClass('pull-header');
                    const pullAuthor = $('<div>').addClass('pull-author').append($('<h4>').text(item
                        .user.name));
                        const pullImage = $('<div>').addClass('pull-image').append($('<img>').attr('src', item.user.image));
                            const pullImg = $('<div>').addClass('pull-img');
                            const pullImgMd = $('<div>').addClass('pull-imgMd').append($('<img>').attr('src', 'img/moldura.png'));

                    const pullLevel = $('<div>').addClass('pull-level').append($('<p>').text(item
                        .user.level), );
                    const pullDate = $('<div>').addClass('pull-date').append($('<p>').text(item
                        .dateTime));
                    const pullBody = $('<div>').addClass('pull-body').append($('<hr>'), $('<p>').text(item.texto));

                    pull.append(pullHeader, pullAuthor, pullImage, pullImg, pullLevel, pullImgMd, pullBody, pullDate);
                    pullContainer.append(pull);
                });
            }
        }

        function loadUserInfo() {
            $.ajax({
                    url: '/postagem/buscarUsuarios', // Altere o URL para a rota correta
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(response) {
                    console.log('Informações do usuário carregadas com sucesso');
                    displayUserInfo(response.usuarios);
                })
                .fail(function(xhr, status, error) {
                    console.error('Erro ao obter informações do usuário', error);
                });
        }

        // Carregar posts e informações do usuário ao carregar a página
        loadForm();
    });
</script>
<script>
    const textarea = document.querySelector('textarea');
    textarea.addEventListener('keyup', e => {
        textarea.style.height = "63px";
        let scHeight = e.target.scHeight;
        textarea.style.height = `${scHeight}px`;
    });
</script>





<script id="noise" type="x-shader/x-fragment">
  #define NUM_OCTAVES 5

vec3 mod289(vec3 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
vec2 mod289(vec2 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
vec3 permute(vec3 x) { return mod289(((x*34.0)+1.0)*x); }

float rand(float n){return fract(sin(n) * 43758.5453123);}
float rand(vec2 n) { 
    return fract(sin(dot(n, vec2(12.9898, 4.1414))) * 43758.5453);
}
float noise(float p){
    float fl = floor(p);
  float fc = fract(p);
    return mix(rand(fl), rand(fl + 1.0), fc);
}
float noise(vec2 n) {
    const vec2 d = vec2(0.0, 1.0);
  vec2 b = floor(n), f = smoothstep(vec2(0.0), vec2(1.0), fract(n));
    return mix(mix(rand(b), rand(b + d.yx), f.x), mix(rand(b + d.xy), rand(b + d.yy), f.x), f.y);
}

float snoise(vec2 v) {
    const vec4 C = vec4(0.211324865405187,  // (3.0-sqrt(3.0))/6.0
                        0.366025403784439,  // 0.5*(sqrt(3.0)-1.0)
                        -0.577350269189626,  // -1.0 + 2.0 * C.x
                        0.024390243902439); // 1.0 / 41.0
    vec2 i  = floor(v + dot(v, C.yy) );
    vec2 x0 = v -   i + dot(i, C.xx);
    vec2 i1;
    i1 = (x0.x > x0.y) ? vec2(1.0, 0.0) : vec2(0.0, 1.0);
    vec4 x12 = x0.xyxy + C.xxzz;
    x12.xy -= i1;
    i = mod289(i); // Avoid truncation effects in permutation
    vec3 p = permute( permute( i.y + vec3(0.0, i1.y, 1.0 ))
        + i.x + vec3(0.0, i1.x, 1.0 ));

    vec3 m = max(0.5 - vec3(dot(x0,x0), dot(x12.xy,x12.xy), dot(x12.zw,x12.zw)), 0.0);
    m = m*m ;
    m = m*m ;
    vec3 x = 2.0 * fract(p * C.www) - 1.0;
    vec3 h = abs(x) - 0.5;
    vec3 ox = floor(x + 0.5);
    vec3 a0 = x - ox;
    m *= 1.79284291400159 - 0.85373472095314 * ( a0*a0 + h*h );
    vec3 g;
    g.x  = a0.x  * x0.x  + h.x  * x0.y;
    g.yz = a0.yz * x12.xz + h.yz * x12.yw;
    return 130.0 * dot(m, g);
}
const mat2 m2 = mat2(0.8,-0.6,0.6,0.8);

#define NB_OCTAVES 8
#define LACUNARITY 10.0
#define GAIN 0.5

float fbm(in vec2 p) {
    float total = 0.0,
        frequency = 1.0,
        amplitude = 1.0;
    
    for (int i = 0; i < NB_OCTAVES; i++) {
        total += snoise(p * frequency) * amplitude;
        frequency *= LACUNARITY;
        amplitude *= GAIN;
    }    
    return total;
}

</script>
<script id="vertex" type="x-shader/x-fragment">
  uniform float u_time;
uniform float u_height;
uniform vec2 u_rand;

float xDistortion;
float yDistortion;

varying float vDistortion;
varying vec2 vUv;

void main() {
    vUv = uv;
    vDistortion = snoise(vUv.xx * 3. - vec2(u_time / u_rand.x, u_time / u_rand.x) + cos(vUv.yy) * u_rand.y) * u_height;
    xDistortion = snoise(vUv.xx * 1.) * u_height * u_rand.x / 10.;
    vec3 pos = position;
    pos.z += (vDistortion * 55.);
    pos.x += (xDistortion * 55.);
    pos.y += (sin(vUv.y) * 55.);
    
    gl_Position = projectionMatrix * modelViewMatrix * vec4(pos, 1.0);
}

</script>
<script id="fragment" type="x-shader/x-fragment">
  vec3 rgb(float r, float g, float b) {
    return vec3(r / 255., g / 255., b / 255.);
}
vec3 rgb(float c) {
    return vec3(c / 255., c / 255., c / 255.);
}

uniform vec3 u_lowColor;
uniform vec3 u_highColor;
uniform float u_time;

varying vec2 vUv;
varying float vDistortion;
varying float xDistortion;

void main() {
    vec3 highColor = rgb(u_highColor.r, u_highColor.g, u_highColor.b);
    
    vec3 colorMap = rgb(u_lowColor.r, u_lowColor.g, u_lowColor.b);

    colorMap = mix(colorMap, highColor, vDistortion);
    
    gl_FragColor = vec4(colorMap, 1.);
}

  </script>
<script src="https://kit.fontawesome.com/48764efa36.js" crossorigin="anonymous"></script>

