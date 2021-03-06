"""mysite URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""

# 최상위 URLconf
from django.contrib import admin
from django.urls import include, path

urlpatterns = [
    # path(route, view, ...)
    path('polls/', include('polls.urls')),
    # polls.urls 모듈을 바라보게 설정(urls.py) 즉, mysite.urls.py <- polls.urls.py <- view.index(method)
    path('admin/', admin.site.urls),
]
