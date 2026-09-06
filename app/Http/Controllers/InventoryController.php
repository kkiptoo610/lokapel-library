<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventoryIssue;
use App\Models\InventoryItem;
use App\Models\InventoryRestock;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Default Inventory Categories
    |--------------------------------------------------------------------------
    */

    private function ensureDefaultCategories(): void
    {
        $categories = [
            [
                'name' => 'Teachers Inventory',
                'type' => 'teachers',
            ],
            [
                'name' => 'Laboratory Inventory',
                'type' => 'laboratory',
            ],
        ];

        foreach ($categories as $category) {
            InventoryCategory::firstOrCreate(
                [
                    'name' => $category['name'],
                ],
                [
                    'type' => $category['type'],
                ]
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | School Departments
    |--------------------------------------------------------------------------
    */

    private function schoolDepartments(): array
    {
        return [

            'Administration',

            'Principal Office',

            'Deputy Principal Office',

            'Academic Department',

            'Examinations Department',

            'Mathematics Department',

            'English Department',

            'Kiswahili Department',

            'Science Department',

            'Physics Department',

            'Chemistry Department',

            'Biology Department',

            'Humanities Department',

            'History Department',

            'Geography Department',

            'Religious Education Department',

            'Business Studies Department',

            'Computer Studies Department',

            'Agriculture Department',

            'Home Science Department',

            'Art and Design Department',

            'Music Department',

            'Physical Education Department',

            'Sports Department',

            'Library',

            'Laboratory',

            'ICT Department',

            'Guidance and Counselling Department',

            'Boarding Department',

            'Catering Department',

            'Procurement Department',

            'Finance Department',

            'Accounts Department',

            'Human Resource Department',

            'Security Department',

            'Maintenance Department',

            'Transport Department',

            'Student Affairs Department',

            'Discipline Department',

            'School Store',

            'General Office',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Main Inventory Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->ensureDefaultCategories();

        $totalItems = InventoryItem::count();

        $totalStock = InventoryItem::sum('quantity') ?? 0;

        $teacherItems = InventoryItem::whereHas(
            'category',
            function ($query) {
                $query->where('type', 'teachers');
            }
        )->count();

        $laboratoryItems = InventoryItem::whereHas(
            'category',
            function ($query) {
                $query->where('type', 'laboratory');
            }
        )->count();

        $lowStockCount = InventoryItem::whereColumn(
            'quantity',
            '<=',
            'minimum_quantity'
        )
            ->where('quantity', '>', 0)
            ->count();

        $lowStockItems = $lowStockCount;

        $outOfStockItems = InventoryItem::where(
            'quantity',
            '<=',
            0
        )->count();

        $outOfStockCount = $outOfStockItems;

        $issuedItemsCount = InventoryIssue::sum('quantity') ?? 0;

        $issuedItems = $issuedItemsCount;

        $restockedItemsCount = InventoryRestock::sum('quantity') ?? 0;

        $restockedItems = $restockedItemsCount;

        $totalRestockRecords = InventoryRestock::count();

        $totalIssueRecords = InventoryIssue::count();

        $categories = InventoryCategory::withCount('items')
            ->orderBy('name')
            ->get();

        $recentItems = InventoryItem::with('category')
            ->latest()
            ->limit(10)
            ->get();

        $recentIssues = InventoryIssue::with([
            'item',
            'teacher',
        ])
            ->latest('issued_date')
            ->latest()
            ->limit(10)
            ->get();

        $recentRestocks = InventoryRestock::with([
            'item',
        ])
            ->latest('restocked_date')
            ->latest()
            ->limit(10)
            ->get();

        return view(
            'inventory.index',
            compact(
                'totalItems',
                'totalStock',
                'teacherItems',
                'laboratoryItems',
                'lowStockCount',
                'lowStockItems',
                'outOfStockItems',
                'outOfStockCount',
                'issuedItemsCount',
                'issuedItems',
                'restockedItemsCount',
                'restockedItems',
                'totalRestockRecords',
                'totalIssueRecords',
                'categories',
                'recentItems',
                'recentIssues',
                'recentRestocks'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Teachers Inventory Dashboard
    |--------------------------------------------------------------------------
    */

    public function teachers()
    {
        $this->ensureDefaultCategories();

        $items = InventoryItem::with('category')
            ->whereHas(
                'category',
                function ($query) {
                    $query->where('type', 'teachers');
                }
            )
            ->orderBy('name')
            ->get();

        $lowStock = $items
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= $item->minimum_quantity;
            })
            ->count();

        $criticalStock = $items
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= 2;
            })
            ->count();

        $outOfStock = $items
            ->filter(function ($item) {
                return $item->quantity <= 0;
            })
            ->count();

        $remainingStock = $items->sum('quantity');

        $issuedItems = InventoryIssue::whereHas(
            'item.category',
            function ($query) {
                $query->where('type', 'teachers');
            }
        )->sum('quantity') ?? 0;

        $restockedItems = InventoryRestock::whereHas(
            'item.category',
            function ($query) {
                $query->where('type', 'teachers');
            }
        )->sum('quantity') ?? 0;

        $recentIssues = InventoryIssue::with([
            'item',
            'teacher',
        ])
            ->whereHas(
                'item.category',
                function ($query) {
                    $query->where('type', 'teachers');
                }
            )
            ->latest('issued_date')
            ->latest()
            ->limit(10)
            ->get();

        $recentRestocks = InventoryRestock::with('item')
            ->whereHas(
                'item.category',
                function ($query) {
                    $query->where('type', 'teachers');
                }
            )
            ->latest('restocked_date')
            ->latest()
            ->limit(10)
            ->get();

        return view(
            'inventory.teachers',
            compact(
                'items',
                'lowStock',
                'criticalStock',
                'outOfStock',
                'remainingStock',
                'issuedItems',
                'restockedItems',
                'recentIssues',
                'recentRestocks'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Laboratory Inventory Dashboard
    |--------------------------------------------------------------------------
    */

    public function laboratory()
    {
        $this->ensureDefaultCategories();

        $items = InventoryItem::with('category')
            ->whereHas(
                'category',
                function ($query) {
                    $query->where('type', 'laboratory');
                }
            )
            ->orderBy('name')
            ->get();

        $lowStock = $items
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= $item->minimum_quantity;
            })
            ->count();

        $criticalStock = $items
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= 2;
            })
            ->count();

        $outOfStock = $items
            ->filter(function ($item) {
                return $item->quantity <= 0;
            })
            ->count();

        $remainingStock = $items->sum('quantity');

        $issuedItems = InventoryIssue::whereHas(
            'item.category',
            function ($query) {
                $query->where('type', 'laboratory');
            }
        )->sum('quantity') ?? 0;

        $restockedItems = InventoryRestock::whereHas(
            'item.category',
            function ($query) {
                $query->where('type', 'laboratory');
            }
        )->sum('quantity') ?? 0;

        $recentIssues = InventoryIssue::with([
            'item',
            'teacher',
        ])
            ->whereHas(
                'item.category',
                function ($query) {
                    $query->where('type', 'laboratory');
                }
            )
            ->latest('issued_date')
            ->latest()
            ->limit(10)
            ->get();

        $recentRestocks = InventoryRestock::with('item')
            ->whereHas(
                'item.category',
                function ($query) {
                    $query->where('type', 'laboratory');
                }
            )
            ->latest('restocked_date')
            ->latest()
            ->limit(10)
            ->get();

        return view(
            'inventory.laboratory',
            compact(
                'items',
                'lowStock',
                'criticalStock',
                'outOfStock',
                'remainingStock',
                'issuedItems',
                'restockedItems',
                'recentIssues',
                'recentRestocks'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | All Inventory Items
    |--------------------------------------------------------------------------
    */

    public function items(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT: Create Default Categories
        |--------------------------------------------------------------------------
        */

        $this->ensureDefaultCategories();

        /*
        |--------------------------------------------------------------------------
        | Categories For Filter Dropdown
        |--------------------------------------------------------------------------
        */

        $categories = InventoryCategory::orderBy('name')->get();

        $query = InventoryItem::with('category');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                function ($query) use ($search) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'category',
                        function ($categoryQuery) use ($search) {
                            $categoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {
            $query->where(
                'inventory_category_id',
                $request->category
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Inventory Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {
            $query->whereHas(
                'category',
                function ($categoryQuery) use ($request) {
                    $categoryQuery->where(
                        'type',
                        $request->type
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalItems = (clone $query)->count();

        $totalQuantity = (clone $query)->sum('quantity') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Paginated Inventory Items
        |--------------------------------------------------------------------------
        */

        $items = $query
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.items.index',
            compact(
                'items',
                'categories',
                'totalItems',
                'totalQuantity'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Inventory Stock Overview
    |--------------------------------------------------------------------------
    */

    public function stock(Request $request)
    {
        $this->ensureDefaultCategories();

        $categories = InventoryCategory::orderBy('name')->get();

        $query = InventoryItem::with('category');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                function ($query) use ($search) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'category',
                        function ($categoryQuery) use ($search) {
                            $categoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
                }
            );
        }

        if ($request->filled('category')) {
            $query->where(
                'inventory_category_id',
                $request->category
            );
        }

        if ($request->filled('type')) {
            $query->whereHas(
                'category',
                function ($categoryQuery) use ($request) {
                    $categoryQuery->where(
                        'type',
                        $request->type
                    );
                }
            );
        }

        $totalItems = (clone $query)->count();

        $totalStock = (clone $query)->sum('quantity') ?? 0;

        $lowStockCount = (clone $query)
            ->whereColumn(
                'quantity',
                '<=',
                'minimum_quantity'
            )
            ->where(
                'quantity',
                '>',
                0
            )
            ->count();

        $outOfStockCount = (clone $query)
            ->where(
                'quantity',
                '<=',
                0
            )
            ->count();

        $items = $query
            ->orderByDesc('quantity')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.stock',
            compact(
                'items',
                'categories',
                'totalItems',
                'totalStock',
                'lowStockCount',
                'outOfStockCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Inventory Item Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->ensureDefaultCategories();

        $categories = InventoryCategory::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Teachers Inventory Preset Items
        |--------------------------------------------------------------------------
        */

        $teacherPresetItems = [

            [
                'name' => 'Blue Marker',
                'description' => 'Blue whiteboard markers for classroom teaching.',
            ],

            [
                'name' => 'Black Marker',
                'description' => 'Black whiteboard markers.',
            ],

            [
                'name' => 'Red Marker',
                'description' => 'Red whiteboard markers.',
            ],

            [
                'name' => 'Green Marker',
                'description' => 'Green whiteboard markers.',
            ],

            [
                'name' => 'Chalk',
                'description' => 'White and colored chalk for classroom use.',
            ],

            [
                'name' => 'Duster',
                'description' => 'Whiteboard and chalkboard dusters.',
            ],

            [
                'name' => 'Exercise Books',
                'description' => 'Books for teacher lesson preparation and records.',
            ],

            [
                'name' => 'Manila Papers',
                'description' => 'Teaching and classroom presentation materials.',
            ],

            [
                'name' => 'Rulers',
                'description' => 'Rulers for teaching and classroom activities.',
            ],

            [
                'name' => 'Permanent Marker',
                'description' => 'Permanent markers for labeling and general use.',
            ],

            [
                'name' => 'Pens',
                'description' => 'Ballpoint pens for teachers.',
            ],

            [
                'name' => 'Pencils',
                'description' => 'Pencils for classroom and administrative use.',
            ],

            [
                'name' => 'Staplers',
                'description' => 'Staplers for office and teaching documents.',
            ],

            [
                'name' => 'Staples',
                'description' => 'Stapler refill pins.',
            ],

            [
                'name' => 'Punching Machine',
                'description' => 'Paper punching machines.',
            ],

            [
                'name' => 'Files',
                'description' => 'Files for storing teaching documents.',
            ],

            [
                'name' => 'Folders',
                'description' => 'Folders for teacher records.',
            ],

            [
                'name' => 'A4 Printing Paper',
                'description' => 'Printing and photocopying paper.',
            ],

            [
                'name' => 'Sticky Notes',
                'description' => 'Notes for reminders and organization.',
            ],

            [
                'name' => 'Scissors',
                'description' => 'Scissors for teaching and office activities.',
            ],

            [
                'name' => 'Glue',
                'description' => 'Adhesive for teaching materials.',
            ],

            [
                'name' => 'Attendance Register',
                'description' => 'Registers for recording learner attendance.',
            ],

            [
                'name' => 'Lesson Plan Book',
                'description' => 'Books for preparing lesson plans.',
            ],

            [
                'name' => 'Record of Work Book',
                'description' => 'Books for recording completed syllabus work.',
            ],

            [
                'name' => 'Teacher\'s Diary',
                'description' => 'Daily teacher planning and record book.',
            ],

            [
                'name' => 'Flash Disks',
                'description' => 'Storage devices for teaching resources.',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Laboratory Preset Items
        |--------------------------------------------------------------------------
        */

        $laboratoryPresetItems = [

            [
                'name' => 'Beakers 100ml',
                'description' => 'Glass beakers for laboratory experiments.',
            ],

            [
                'name' => 'Beakers 250ml',
                'description' => 'Glass beakers for laboratory experiments.',
            ],

            [
                'name' => 'Beakers 500ml',
                'description' => 'Large glass beakers.',
            ],

            [
                'name' => 'Measuring Cylinder 100ml',
                'description' => 'Used for measuring liquids accurately.',
            ],

            [
                'name' => 'Measuring Cylinder 250ml',
                'description' => 'Used for measuring larger liquid volumes.',
            ],

            [
                'name' => 'Test Tubes',
                'description' => 'Containers for chemical experiments.',
            ],

            [
                'name' => 'Test Tube Holder',
                'description' => 'Holds test tubes during experiments.',
            ],

            [
                'name' => 'Test Tube Rack',
                'description' => 'Holds test tubes upright.',
            ],

            [
                'name' => 'Conical Flask 250ml',
                'description' => 'Used for mixing and chemical reactions.',
            ],

            [
                'name' => 'Conical Flask 500ml',
                'description' => 'Large laboratory flask.',
            ],

            [
                'name' => 'Thermometer',
                'description' => 'Measures temperature.',
            ],

            [
                'name' => 'Tripod Stand',
                'description' => 'Supports apparatus during heating.',
            ],

            [
                'name' => 'Wire Gauze',
                'description' => 'Supports containers during heating.',
            ],

            [
                'name' => 'Bunsen Burner',
                'description' => 'Gas burner for heating.',
            ],

            [
                'name' => 'Spatula',
                'description' => 'Transfers small quantities of chemicals.',
            ],

            [
                'name' => 'Glass Stirring Rod',
                'description' => 'Used for stirring solutions.',
            ],

            [
                'name' => 'Funnel',
                'description' => 'Used for transferring liquids.',
            ],

            [
                'name' => 'Evaporating Dish',
                'description' => 'Used for evaporation experiments.',
            ],

            [
                'name' => 'Watch Glass',
                'description' => 'Used in evaporation and covering containers.',
            ],

            [
                'name' => 'Mortar and Pestle',
                'description' => 'Used for grinding substances.',
            ],

            [
                'name' => 'Balance',
                'description' => 'Measures mass of substances.',
            ],

            [
                'name' => 'Retort Stand',
                'description' => 'Supports laboratory apparatus.',
            ],

            [
                'name' => 'Clamp',
                'description' => 'Holds laboratory apparatus.',
            ],

            [
                'name' => 'Dropper',
                'description' => 'Transfers small quantities of liquid.',
            ],

            [
                'name' => 'Wash Bottle',
                'description' => 'Used for washing laboratory apparatus.',
            ],

            [
                'name' => 'Petri Dish',
                'description' => 'Used for biological experiments.',
            ],

            [
                'name' => 'Microscope',
                'description' => 'Used for observing microscopic specimens.',
            ],

            [
                'name' => 'Microscope Slides',
                'description' => 'Used for preparing specimens.',
            ],

            [
                'name' => 'Cover Slips',
                'description' => 'Used for covering microscope specimens.',
            ],

            [
                'name' => 'Specimen Bottles',
                'description' => 'Stores biological specimens.',
            ],

            [
                'name' => 'Dissecting Kit',
                'description' => 'Used for biological dissection experiments.',
            ],

            [
                'name' => 'Forceps',
                'description' => 'Used for handling small specimens.',
            ],

            [
                'name' => 'Scalpel',
                'description' => 'Used for laboratory dissection.',
            ],

            [
                'name' => 'Dissecting Tray',
                'description' => 'Used during biological dissection.',
            ],

            [
                'name' => 'Hand Lens',
                'description' => 'Used for magnifying small specimens.',
            ],

            [
                'name' => 'Specimen Jars',
                'description' => 'Used for storing biological specimens.',
            ],

            [
                'name' => 'Model of Human Heart',
                'description' => 'Educational model of the human heart.',
            ],

            [
                'name' => 'Model of Human Torso',
                'description' => 'Educational model of the human body.',
            ],

            [
                'name' => 'Skeleton Model',
                'description' => 'Educational model of the human skeleton.',
            ],

            [
                'name' => 'Prepared Slides',
                'description' => 'Prepared microscope slides for biological study.',
            ],

            [
                'name' => 'Burette',
                'description' => 'Used for accurate liquid measurement in titration.',
            ],

            [
                'name' => 'Pipette',
                'description' => 'Used for transferring measured liquid volumes.',
            ],

            [
                'name' => 'Pipette Filler',
                'description' => 'Used with pipettes for safe liquid transfer.',
            ],

            [
                'name' => 'Volumetric Flask',
                'description' => 'Used for preparing solutions of accurate volumes.',
            ],

            [
                'name' => 'Test Tube',
                'description' => 'Used for chemical experiments.',
            ],

            [
                'name' => 'Chemical Reagent Bottles',
                'description' => 'Used for storing laboratory chemicals.',
            ],

            [
                'name' => 'Crucible',
                'description' => 'Used for heating substances at high temperatures.',
            ],

            [
                'name' => 'Crucible Tongs',
                'description' => 'Used for handling hot crucibles.',
            ],

            [
                'name' => 'pH Paper',
                'description' => 'Used for testing acidity and alkalinity.',
            ],

            [
                'name' => 'Filter Paper',
                'description' => 'Used for filtering laboratory solutions.',
            ],

            [
                'name' => 'Ammeter',
                'description' => 'Used for measuring electric current.',
            ],

            [
                'name' => 'Voltmeter',
                'description' => 'Used for measuring electrical voltage.',
            ],

            [
                'name' => 'Galvanometer',
                'description' => 'Used for detecting small electric currents.',
            ],

            [
                'name' => 'Connecting Wires',
                'description' => 'Used for making electrical circuit connections.',
            ],

            [
                'name' => 'Resistors',
                'description' => 'Used for controlling electrical current.',
            ],

            [
                'name' => 'Switches',
                'description' => 'Used for opening and closing electrical circuits.',
            ],

            [
                'name' => 'Cells',
                'description' => 'Used as electrical energy sources.',
            ],

            [
                'name' => 'Magnets',
                'description' => 'Used for magnetism experiments.',
            ],

            [
                'name' => 'Metre Rule',
                'description' => 'Used for measuring length.',
            ],

            [
                'name' => 'Vernier Caliper',
                'description' => 'Used for accurate measurement of dimensions.',
            ],

            [
                'name' => 'Micrometer Screw Gauge',
                'description' => 'Used for measuring very small dimensions.',
            ],

            [
                'name' => 'Spring Balance',
                'description' => 'Used for measuring force or weight.',
            ],

            [
                'name' => 'Stop Watch',
                'description' => 'Used for measuring time accurately.',
            ],

            [
                'name' => 'Laboratory Coat',
                'description' => 'Protective clothing for laboratory users.',
            ],

            [
                'name' => 'Safety Goggles',
                'description' => 'Protects the eyes during laboratory experiments.',
            ],

            [
                'name' => 'Protective Gloves',
                'description' => 'Protects hands when handling laboratory materials.',
            ],

            [
                'name' => 'First Aid Kit',
                'description' => 'Contains supplies for emergency first aid.',
            ],

            [
                'name' => 'Fire Extinguisher',
                'description' => 'Used for controlling laboratory fires.',
            ],

            [
                'name' => 'Safety Signage',
                'description' => 'Safety signs and warnings for the laboratory.',
            ],

            [
                'name' => 'Laboratory Waste Bin',
                'description' => 'Used for safe disposal of laboratory waste.',
            ],
        ];

        return view(
            'inventory.items.create',
            compact(
                'categories',
                'teacherPresetItems',
                'laboratoryPresetItems'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Inventory Item
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_category_id' => [
                'required',
                'exists:inventory_categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'unit' => [
                'required',
                'string',
                'max:100',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $item = InventoryItem::create($validated);

        return redirect()
            ->route('inventory.items.show', $item)
            ->with(
                'success',
                'Inventory item added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Inventory Item
    |--------------------------------------------------------------------------
    */

    public function show(InventoryItem $item)
    {
        $item->load('category');

        $issues = InventoryIssue::with([
            'teacher',
            'item',
        ])
            ->where(
                'inventory_item_id',
                $item->id
            )
            ->latest('issued_date')
            ->latest()
            ->get();

        $restocks = InventoryRestock::with('item')
            ->where(
                'inventory_item_id',
                $item->id
            )
            ->latest('restocked_date')
            ->latest()
            ->get();

        $totalIssued = $issues->sum('quantity');

        $totalRestocked = $restocks->sum('quantity');

        $issueRecordsCount = $issues->count();

        $restockRecordsCount = $restocks->count();

        return view(
            'inventory.items.show',
            compact(
                'item',
                'issues',
                'restocks',
                'totalIssued',
                'totalRestocked',
                'issueRecordsCount',
                'restockRecordsCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Inventory Item Form
    |--------------------------------------------------------------------------
    */

    public function edit(InventoryItem $item)
    {
        $this->ensureDefaultCategories();

        $categories = InventoryCategory::orderBy('name')->get();

        return view(
            'inventory.items.edit',
            compact(
                'item',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Inventory Item
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        InventoryItem $item
    ) {
        $validated = $request->validate([
            'inventory_category_id' => [
                'required',
                'exists:inventory_categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'unit' => [
                'required',
                'string',
                'max:100',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $item->update($validated);

        return redirect()
            ->route(
                'inventory.items.show',
                $item
            )
            ->with(
                'success',
                'Inventory item updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Inventory Item
    |--------------------------------------------------------------------------
    */

    public function destroy(InventoryItem $item)
    {
        if ($item->issues()->exists()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This inventory item cannot be deleted because it has issue history.'
                );
        }

        $item->delete();

        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Inventory item deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Inventory Issue Form
    |--------------------------------------------------------------------------
    */

    public function showIssueForm(InventoryItem $item)
    {
        $item->load('category');

        $teachers = Teacher::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT: Send All Departments To The View
        |--------------------------------------------------------------------------
        */

        $departments = $this->schoolDepartments();

        return view(
            'inventory.items.issue',
            compact(
                'item',
                'teachers',
                'departments'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Issue Inventory Item
    |--------------------------------------------------------------------------
    */

    public function issue(
        Request $request,
        InventoryItem $item
    ) {
        $validated = $request->validate([
            'teacher_id' => [
                'nullable',
                'exists:teachers,id',
            ],

            'department' => [
                'nullable',
                'string',
                'max:255',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'issued_date' => [
                'required',
                'date',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        if (
            empty($validated['teacher_id'])
            &&
            empty($validated['department'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'teacher_id' =>
                        'Please select a teacher or department.',
                ]);
        }

        if ($validated['quantity'] > $item->quantity) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The quantity being issued is greater than the available stock.'
                );
        }

        DB::transaction(
            function () use (
                $validated,
                $item
            ) {
                InventoryIssue::create([
                    'inventory_item_id' => $item->id,

                    'teacher_id' =>
                        $validated['teacher_id'] ?? null,

                    'department' =>
                        $validated['department'] ?? null,

                    'quantity' =>
                        $validated['quantity'],

                    'issued_date' =>
                        $validated['issued_date'],

                    'remarks' =>
                        $validated['remarks'] ?? null,
                ]);

                $item->decrement(
                    'quantity',
                    $validated['quantity']
                );
            }
        );

        return redirect()
            ->route(
                'inventory.items.show',
                $item
            )
            ->with(
                'success',
                'Inventory item issued successfully and stock updated.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Inventory Restock Form
    |--------------------------------------------------------------------------
    */

    public function showRestockForm(InventoryItem $item)
    {
        $item->load('category');

        return view(
            'inventory.items.restock',
            compact('item')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restock Inventory Item
    |--------------------------------------------------------------------------
    */

    public function restock(
        Request $request,
        InventoryItem $item
    ) {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'restocked_date' => [
                'required',
                'date',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(
            function () use (
                $validated,
                $item
            ) {
                InventoryRestock::create([
                    'inventory_item_id' => $item->id,

                    'quantity' =>
                        $validated['quantity'],

                    'restocked_date' =>
                        $validated['restocked_date'],

                    'remarks' =>
                        $validated['remarks'] ?? null,
                ]);

                $item->increment(
                    'quantity',
                    $validated['quantity']
                );
            }
        );

        return redirect()
            ->route(
                'inventory.items.show',
                $item
            )
            ->with(
                'success',
                'Inventory item restocked successfully and stock updated.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Inventory Issue History
    |--------------------------------------------------------------------------
    */

    public function issues(Request $request)
    {
        $query = InventoryIssue::with([
            'item.category',
            'teacher',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                function ($query) use ($search) {
                    $query->whereHas(
                        'item',
                        function ($itemQuery) use ($search) {
                            $itemQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    )
                        ->orWhereHas(
                            'teacher',
                            function ($teacherQuery) use ($search) {
                                $teacherQuery->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );
                            }
                        )
                        ->orWhere(
                            'department',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }

        if ($request->filled('type')) {
            $query->whereHas(
                'item.category',
                function ($categoryQuery) use ($request) {
                    $categoryQuery->where(
                        'type',
                        $request->type
                    );
                }
            );
        }

        if ($request->filled('date_from')) {
            $query->whereDate(
                'issued_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'issued_date',
                '<=',
                $request->date_to
            );
        }

        $totalIssuedQuantity =
            (clone $query)->sum('quantity');

        $totalIssueRecords =
            (clone $query)->count();

        $issues = $query
            ->latest('issued_date')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.issues',
            compact(
                'issues',
                'totalIssuedQuantity',
                'totalIssueRecords'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Inventory Restock History
    |--------------------------------------------------------------------------
    */

    public function restocks(Request $request)
    {
        $query = InventoryRestock::with([
            'item.category',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas(
                'item',
                function ($itemQuery) use ($search) {
                    $itemQuery->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    );
                }
            );
        }

        if ($request->filled('type')) {
            $query->whereHas(
                'item.category',
                function ($categoryQuery) use ($request) {
                    $categoryQuery->where(
                        'type',
                        $request->type
                    );
                }
            );
        }

        if ($request->filled('date_from')) {
            $query->whereDate(
                'restocked_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'restocked_date',
                '<=',
                $request->date_to
            );
        }

        $totalRestockedQuantity =
            (clone $query)->sum('quantity');

        $totalRestockRecords =
            (clone $query)->count();

        $restocks = $query
            ->latest('restocked_date')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.restocks',
            compact(
                'restocks',
                'totalRestockedQuantity',
                'totalRestockRecords'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Low Stock Inventory
    |--------------------------------------------------------------------------
    */

    public function lowStock(Request $request)
    {
        $query = InventoryItem::with('category')
            ->where(
                function ($query) {
                    $query->whereColumn(
                        'quantity',
                        '<=',
                        'minimum_quantity'
                    )
                    ->orWhere(
                        'quantity',
                        '<=',
                        0
                    );
                }
            );

        if ($request->filled('type')) {
            $query->whereHas(
                'category',
                function ($categoryQuery) use ($request) {
                    $categoryQuery->where(
                        'type',
                        $request->type
                    );
                }
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'name',
                'like',
                '%' . $search . '%'
            );
        }

        $allItems = (clone $query)->get();

        $lowStockCount = $allItems
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= $item->minimum_quantity;
            })
            ->count();

        $outOfStockCount = $allItems
            ->filter(function ($item) {
                return $item->quantity <= 0;
            })
            ->count();

        $criticalStockCount = $allItems
            ->filter(function ($item) {
                return $item->quantity > 0
                    && $item->quantity <= 2;
            })
            ->count();

        $items = $query
            ->orderBy('quantity')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.low-stock',
            compact(
                'items',
                'lowStockCount',
                'outOfStockCount',
                'criticalStockCount'
            )
        );
    }
}