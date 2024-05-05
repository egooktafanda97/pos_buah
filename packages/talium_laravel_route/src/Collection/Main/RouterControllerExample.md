### Penggunaan Controller
```php
use TaliumAbstract\Attributes\Ruters\Get;
use TaliumAbstract\Attributes\Ruters\Group;
use TaliumAbstract\Attributes\Ruters\Name;
use TaliumAbstract\Attributes\Controllers;
use TaliumAbstract\Permission\RoleServices;

#[Controllers()]
#[Group(["name" => "rules", "prefix" => "rules", "group" => "rule-permission"])]
#[Name("rules")]
class  MasterRulesController extends Controller
{
    #[Get("")]
    #[Name("set rules")]
    public function setUpRules(RoleServices $ruleService, Request $request)
    {
        return $ruleService->saveRules((
            new Request([
                "role" => "super-admin",
                "gaurd_name" => "api",
                "guard_api" => true,
            ])
        ));
    }
}

```
#### Deskripsi
- `Controllers` adalah atribut yang digunakan untuk menandai bahwa class tersebut adalah controller.
- `Group` adalah atribut yang digunakan untuk menandai bahwa class tersebut adalah group dari controller.
- `Name` adalah atribut yang digunakan untuk menandai bahwa class tersebut adalah nama dari controller.
- `Get` adalah atribut yang digunakan untuk menandai bahwa method tersebut adalah method GET.
- `Name` adalah atribut yang digunakan untuk menandai bahwa method tersebut adalah nama dari method.
