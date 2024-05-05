namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'name', 'price', 'quantity', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}