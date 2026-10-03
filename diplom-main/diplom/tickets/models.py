from django.db import models

class Category(models.Model):
    """Категории ПО: Сигур, Абонемент, РКиПер и др."""
    category_name = models.CharField(max_length=100, unique=True, verbose_name='Название категории')
    
    class Meta:
        verbose_name = 'Категория'
        verbose_name_plural = 'Категории'
    
    def __str__(self):
        return self.category_name


class Status(models.Model):
    """Статусы заявок: Не прочитана, В обработке, Завершена."""
    status_name = models.CharField(max_length=50, unique=True, verbose_name='Название статуса')
    
    class Meta:
        verbose_name = 'Статус'
        verbose_name_plural = 'Статусы'
    
    def __str__(self):
        return self.status_name


class Object(models.Model):
    """Обслуживаемые объекты (кэш из API)."""
    ext_object_id = models.CharField(max_length=100, unique=True, verbose_name='ID объекта')
    object_name = models.CharField(max_length=255, verbose_name='Название объекта')
    
    class Meta:
        verbose_name = 'Объект'
        verbose_name_plural = 'Объекты'
    
    def __str__(self):
        return self.object_name

class Tag(models.Model):
    """Теги для нейросети."""
    tag_name = models.CharField(max_length=100, unique=True)
    
    class Meta:
        verbose_name = 'Тег'
        verbose_name_plural = 'Теги'
    
    def __str__(self):
        return self.tag_name


class Ticket(models.Model):
    """Заявки — центральная таблица."""
    ticket_title = models.CharField(max_length=255)
    ticket_text = models.TextField()
    
    id_status = models.ForeignKey(
        Status,
        on_delete=models.PROTECT,
        default=1,
        verbose_name='Статус'
    )
    id_category = models.ForeignKey(
        Category,
        on_delete=models.PROTECT,
        verbose_name='Категория'
    )
    id_object = models.ForeignKey(
        Object,
        on_delete=models.PROTECT,
        verbose_name='Объект'
    )
    
    visitor_ext_id = models.CharField(max_length=100, blank=True, verbose_name='ID посетителя из ServiceBook')
    visitor_name = models.CharField(max_length=200, verbose_name='ФИО посетителя')
    
    id_employee_assigned = models.ForeignKey(
        'accounts.Employee',
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name='assigned_tickets',
        verbose_name='Назначенный сотрудник'
    )
    id_employee_edited = models.ForeignKey(
        'accounts.Employee',
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name='edited_tickets',
        verbose_name='Последний редактировавший'
    )
    
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    # Связь с тегами M:N
    tags = models.ManyToManyField(Tag, through='TicketTag', blank=True)
    
    class Meta:
        verbose_name = 'Заявка'
        verbose_name_plural = 'Заявки'
        ordering = ['-created_at']
    
    def __str__(self):
        return f'{self.ticket_title} - {self.visitor_name}'


class TicketTag(models.Model):
    """Связь заявок и тегов (M:N)."""
    id_ticket = models.ForeignKey(Ticket, on_delete=models.CASCADE)
    id_tag = models.ForeignKey(Tag, on_delete=models.CASCADE)
    
    class Meta:
        unique_together = ('id_ticket', 'id_tag')
        verbose_name = 'Связь заявки и тега'
        verbose_name_plural = 'Связи заявок и тегов'


class TicketPhoto(models.Model):
    """Фото и скриншоты к заявке."""
    id_ticket = models.ForeignKey(Ticket, on_delete=models.CASCADE)
    file_path = models.ImageField(upload_to='tickets/%Y/%m/', verbose_name='Файл')
    uploaded_at = models.DateTimeField(auto_now_add=True)
    
    class Meta:
        verbose_name = 'Фото заявки'
        verbose_name_plural = 'Фото заявок'