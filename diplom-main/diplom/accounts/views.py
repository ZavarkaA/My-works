from django.shortcuts import render

def accounts_home(request):
    return render(request, 'main/index.html')
