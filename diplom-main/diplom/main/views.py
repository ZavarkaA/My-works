from django.shortcuts import render


def index(request):
    data =  {
        'title': 'Главная страница!!!!',
        'values': ['Some','Hello','123'],
        'obj': {
            'car':'BMW',
            'age': 18,
            'hobby': 'Football'
        }
    }
    return render(request, 'main/index.html', data)

def about(request):
    cry =  {
        'cryi': 'Об нас',
    }
    return render(request, 'main/about.html', cry)


