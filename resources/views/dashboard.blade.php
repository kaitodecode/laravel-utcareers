@extends('layouts.admin')

@section('title', 'Welcome back, Taylor! 👋')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Companies -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Companies</p>
                    <p class="text-3xl font-bold text-gray-900">8</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>12% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Job Posts -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Job Posts</p>
                    <p class="text-3xl font-bold text-gray-900">24</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>8% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-primary bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-black text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Applicants -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Applicants</p>
                    <p class="text-3xl font-bold text-gray-900">156</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>23% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Selections -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Selections</p>
                    <p class="text-3xl font-bold text-gray-900">12</p>
                    <p class="text-sm text-red-600 mt-1">
                        <i class="fas fa-arrow-down mr-1"></i>5% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
                <button class="text-sm text-primary hover:text-black font-medium">View All</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New applicant registered</p>
                        <p class="text-xs text-gray-500">John Doe applied for Software Developer position</p>
                    </div>
                    <span class="text-xs text-gray-400">2 min ago</span>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-primary bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-briefcase text-black"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New job post created</p>
                        <p class="text-xs text-gray-500">IoT Engineer position at PT UT Digital Solutions</p>
                    </div>
                    <span class="text-xs text-gray-400">1 hour ago</span>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Selection completed</p>
                        <p class="text-xs text-gray-500">Interview process for Mining Engineer completed</p>
                    </div>
                    <span class="text-xs text-gray-400">3 hours ago</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
            <div class="space-y-3">
                <button class="w-full flex items-center justify-between p-4 bg-primary hover:bg-opacity-90 rounded-xl transition-colors group">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-plus text-black"></i>
                        <span class="font-medium text-black">Add New Job Post</span>
                    </div>
                    <i class="fas fa-arrow-right text-black group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <button class="w-full flex items-center justify-between p-4 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors group">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-building text-gray-700"></i>
                        <span class="font-medium text-gray-700">Add Company</span>
                    </div>
                    <i class="fas fa-arrow-right text-gray-700 group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <button class="w-full flex items-center justify-between p-4 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors group">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-chart-bar text-gray-700"></i>
                        <span class="font-medium text-gray-700">View Reports</span>
                    </div>
                    <i class="fas fa-arrow-right text-gray-700 group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <button class="w-full flex items-center justify-between p-4 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors group">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-users text-gray-700"></i>
                        <span class="font-medium text-gray-700">Manage Users</span>
                    </div>
                    <i class="fas fa-arrow-right text-gray-700 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Application Trends -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Application Trends</h3>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-primary">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                </select>
            </div>
            <div class="h-64 flex items-end justify-between space-x-2">
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-primary rounded-t" style="height: 60%"></div>
                    <span class="text-xs text-gray-500">Mon</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-gray-300 rounded-t" style="height: 40%"></div>
                    <span class="text-xs text-gray-500">Tue</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-primary rounded-t" style="height: 80%"></div>
                    <span class="text-xs text-gray-500">Wed</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-gray-300 rounded-t" style="height: 30%"></div>
                    <span class="text-xs text-gray-500">Thu</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-primary rounded-t" style="height: 90%"></div>
                    <span class="text-xs text-gray-500">Fri</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-gray-300 rounded-t" style="height: 20%"></div>
                    <span class="text-xs text-gray-500">Sat</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-8 bg-gray-300 rounded-t" style="height: 10%"></div>
                    <span class="text-xs text-gray-500">Sun</span>
                </div>
            </div>
        </div>

        <!-- Top Companies -->
        <div class="bg-white rounded-2xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Top Companies</h3>
                <button class="text-sm text-primary hover:text-black font-medium">View All</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img class="w-10 h-10 rounded-lg" src="https://ui-avatars.com/api/?name=UT&background=ffd401&color=000" alt="UT">
                        <div>
                            <p class="text-sm font-medium text-gray-900">PT United Tractors</p>
                            <p class="text-xs text-gray-500">5 active jobs</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">45 applicants</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img class="w-10 h-10 rounded-lg" src="https://ui-avatars.com/api/?name=TR&background=2563eb&color=fff" alt="TR">
                        <div>
                            <p class="text-sm font-medium text-gray-900">PT Trakindo Utama</p>
                            <p class="text-xs text-gray-500">3 active jobs</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">32 applicants</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img class="w-10 h-10 rounded-lg" src="https://ui-avatars.com/api/?name=PA&background=059669&color=fff" alt="PA">
                        <div>
                            <p class="text-sm font-medium text-gray-900">PT Pamapersada</p>
                            <p class="text-xs text-gray-500">4 active jobs</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">28 applicants</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img class="w-10 h-10 rounded-lg" src="https://ui-avatars.com/api/?name=UD&background=7c3aed&color=fff" alt="UD">
                        <div>
                            <p class="text-sm font-medium text-gray-900">PT UT Digital Solutions</p>
                            <p class="text-xs text-gray-500">2 active jobs</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">21 applicants</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection