
# Documentação da Estrutura do Projeto TUKADYANE

TUKADYANE é um pacote PHP para geolocalização e exibição de mapas, utilizando OpenStreetMap e Leaflet.js. O nome "TUKADYANE" tem origem em línguas moçambicanas (SHIMAKONDE/MAKONDE).



## 📁 Estrutura de Diretórios

```
TUKADYANE/
├── examples/                  # Exemplos de uso
│   ├── index.html            # Página de exemplo HTML
│   └── map_example.php       # Exemplo de uso do mapa
│
├── src/                      # Código fonte principal
│   ├── Services/             # Serviços do sistema
│   │   ├── NominatimService.php
│   │   └── OSRMService.php
│   ├── Geocoder.php         # Classe principal de geocodificação
│   └── MapRenderer.php      # Renderizador de mapas
│
├── ssl/                      # Certificados SSL
│   └── cacert.pem           # Certificado de segurança
│
├── tests/                    # Testes unitários
│   ├── GeocoderTest.php     # Testes do Geocoder
│   └── MapRendererTest.php  # Testes do MapRenderer
│
├── .gitignore               # Configuração do Git
├── composer.json            # Configuração do Composer
├── composer.lock            # Lock de dependências
├── phpunit.xml             # Configuração do PHPUnit
└── README.md               # Documentação principal
```

## 📝 Descrição dos Componentes

### 1. Diretório `examples/`

Contém exemplos práticos de implementação:

- `index.html`: Demonstração básica de integração HTML

- `map_example.php`: Exemplo completo de uso do mapa


### 2. Diretório `src/`

Código fonte principal do projeto:

#### Services/
```php
// NominatimService.php
// Serviço de geocodificação usando OpenStreetMap
class NominatimService {
    public function geocode($address)
    public function reverse($lat, $lon)
}

// OSRMService.php
// Serviço de rotas
class OSRMService {
    public function getRoute($startLat, $startLon, $endLat, $endLon)
}
```

#### Classes Principais
```php
// Geocoder.php
// Classe principal para geocodificação
class Geocoder {
    public function geocode($address)
    public function reverse($lat, $lon)
}

// MapRenderer.php
// Renderização de mapas
class MapRenderer {
    public static function renderMap($lat, $lon, $zoom = 12)
}
```

### 3. Diretório `ssl/`

- `cacert.pem`: Certificado SSL para requisições seguras


### 4. Diretório `tests/`

Testes unitários do projeto:

```php
// GeocoderTest.php
class GeocoderTest extends TestCase {
    public function testGeocode()
    public function testReverse()
}
```

```php
// MapRendererTest.php
class MapRendererTest extends TestCase {
    public function testRenderMap()
}
```

### 5. Arquivos de Configuração


#### composer.json
```json
{
  "name": "augustodluis/tukadyane",
  "description": "Pacote PHP para geolocalização e mapas",
  "autoload": {
    "psr-4": {
      "Tukadyane\\": "src/"
    }
  }
}
```

#### phpunit.xml
```xml
<phpunit bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Tukadyane">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```


## 🚀 Como Usar

### 1. Instalação
```bash
composer require augustodluis/tukadyane
```

### 1. Instalação
```bash
composer require augustodluis/tukadyane
```

### 2. Exemplo Básico
```php
// examples/map_example.php
require 'vendor/autoload.php';

use Tukadyane\Geocoder;
use Tukadyane\MapRenderer;

$geocoder = new Geocoder();
$result = $geocoder->geocode('Maputo, Moçambique');
echo MapRenderer::renderMap($result->getLatitude(), $result->getLongitude());
```

## 🔧 Configuração do Ambiente de Desenvolvimento

1. Clone o repositório
```bash
git clone https://github.com/augustodluis/tukadyane.git
```

2. Instale as dependências
```bash
composer install
``` 

3. Execute os testes
```bash
composer test
```

## 📚 Convenções de Código

- PSR-4 para autoload
- PSR-12 para estilo de código
- Documentação PHPDoc em todas as classes e métodos
- Testes unitários para todas as funcionalidades    


## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature
3. Faça commit das suas alterações
4. Push para a branch
5. Crie um Pull Request 


📜 Licença
Este projeto está licenciado sob a MIT License.
👨‍💻 Autor

Augusto D. Luis - aluis.mz@yahoo.com

🙏 Agradecimentos

Geocoder PHP - por fornecer a base para este projeto
Nominatim - serviço de geocodificação Open Source






