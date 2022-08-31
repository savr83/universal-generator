# universal-generator
## Ver 0.1
String lists generator used to produce mass strings for XML, and other formats

## 2do
### все задачи
- разделить все на три подзадачи: ручное редактирование, импорт, генерация
### backend
- уникальные поля в выборке источников наборов данных (- лишние переборы)
- ~~php getData() перепесиать с использованием magic method, iterators?~~ реализовано через IteratorAggragate
- добавить пред и пост обработку данных, единообразно для входящих и исходящих данных
- валиадация входящих и исходящих данных
- нагуглить особенности импользования Rule required|...
- переработать метод генерации даннх в DST.
- ВАЖНО! cartesian_product работает как итератор, не использовать массив, включить очереди laravel
- добавить в следующую миграцию fields.validation_rule + rules.processing_logic ->nullable()
- `AttributeName.php` нужен? анах? временно без связи с таблицей категорий, без поля required
- rules -- организовать в дерево для обработки xml
- как добавлять рилейшны в ресурсы ?

### frontend
- ~~frontent UI + Redux (store, reducers, actions)~~ добавлено на базовом уровне
- построить элементы UI
- вложенные роуты и компоненты
- задать специализированные редюсеры по компонентам
- добавить экшны по компонентам

### etc
- ебошить коменты ВЕЗДЕ!!!


## Tips:
Object.keys(arr).length -- 100% длина массива
this.props.actions.ActionName -- доступ к событиям через пропсы (узнать как сформировать) 

debugbar()->log(var_export(['key' => $key, 'conf' => $this->config], true)); // доступ к фасаду


INSERT INTO rules(destination_id, name, processing_logic) VALUES
(1,'RPM', '<param code="RPM" name="Обороты">{{ $record["RPM"] }}</param>'),
(1,'MONTAGE', '<param code="MONTAGE" name="Крепление">{{ $record["MONTAGE"] }}</param>'),
(1,'CLIMATE', '<param code="CLIMATE" name="Климатика">{{ $record["CLIMATE"] }}</param>'),
(1,'PROTECTION', '<param code="PROTECTION" name="Защита">{{ $record["PROTECTION"] }}</param>')


## URLs
https://devarchy.com/redux -- подборка redux библиотек/компонентов

КОНЕЦ!
