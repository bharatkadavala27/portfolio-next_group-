
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    // ...existing code...

    public function filterProducts(Request $request)
    {
        $categories = $request->input('categories', []);
        $brands = $request->input('brands', []);

        $query = Product::query();

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        $products = $query->get();

        return response()->json(['products' => $products]);
    }
}
