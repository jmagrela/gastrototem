from docx import Document
from docx.shared import Pt, Inches, Cm, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.enum.section import WD_ORIENT
from docx.oxml.ns import qn
from docx.oxml import OxmlElement
import os

doc = Document()

# -- Estilos base --
style = doc.styles['Normal']
font = style.font
font.name = 'Helvetica Neue'
font.size = Pt(11)
font.color.rgb = RGBColor(0x1a, 0x1a, 0x1a)
style.paragraph_format.space_after = Pt(6)
style.paragraph_format.line_spacing = 1.4

# Margenes
for section in doc.sections:
    section.top_margin = Cm(2.5)
    section.bottom_margin = Cm(2.5)
    section.left_margin = Cm(2.5)
    section.right_margin = Cm(2.5)

def add_heading_styled(text, level=1):
    h = doc.add_heading(text, level=level)
    for run in h.runs:
        run.font.color.rgb = RGBColor(0x1a, 0x1a, 0x1a)
        run.font.name = 'Helvetica Neue'
    if level == 1:
        h.paragraph_format.space_before = Pt(24)
        h.paragraph_format.space_after = Pt(12)
        # Añadir línea debajo
        pPr = h._p.get_or_add_pPr()
        pBdr = OxmlElement('w:pBdr')
        bottom = OxmlElement('w:bottom')
        bottom.set(qn('w:val'), 'single')
        bottom.set(qn('w:sz'), '12')
        bottom.set(qn('w:space'), '4')
        bottom.set(qn('w:color'), '1a1a1a')
        pBdr.append(bottom)
        pPr.append(pBdr)
    return h

def add_para(text, bold=False, italic=False, size=11, color=None, alignment=None, space_after=6):
    p = doc.add_paragraph()
    run = p.add_run(text)
    run.font.size = Pt(size)
    run.font.name = 'Helvetica Neue'
    run.bold = bold
    run.italic = italic
    if color:
        run.font.color.rgb = RGBColor(*color)
    if alignment:
        p.alignment = alignment
    p.paragraph_format.space_after = Pt(space_after)
    return p

def add_rich_para(parts, space_after=6):
    """parts = lista de (texto, bold, italic, size, color)"""
    p = doc.add_paragraph()
    for text, bold, italic, size, color in parts:
        run = p.add_run(text)
        run.font.size = Pt(size)
        run.font.name = 'Helvetica Neue'
        run.bold = bold
        run.italic = italic
        if color:
            run.font.color.rgb = RGBColor(*color)
    p.paragraph_format.space_after = Pt(space_after)
    return p

def add_bullet(text, bold_prefix=None):
    p = doc.add_paragraph(style='List Bullet')
    if bold_prefix:
        run = p.add_run(bold_prefix)
        run.bold = True
        run.font.size = Pt(11)
        run.font.name = 'Helvetica Neue'
        run = p.add_run(text)
        run.font.size = Pt(11)
        run.font.name = 'Helvetica Neue'
    else:
        p.clear()
        run = p.add_run(text)
        run.font.size = Pt(11)
        run.font.name = 'Helvetica Neue'
    return p

def set_cell_shading(cell, color):
    shading = OxmlElement('w:shd')
    shading.set(qn('w:fill'), color)
    shading.set(qn('w:val'), 'clear')
    cell._tc.get_or_add_tcPr().append(shading)

def add_table(headers, rows):
    table = doc.add_table(rows=1 + len(rows), cols=len(headers))
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    # Header
    for i, h in enumerate(headers):
        cell = table.rows[0].cells[i]
        cell.text = h
        for p in cell.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.LEFT
            for run in p.runs:
                run.font.size = Pt(10)
                run.font.bold = True
                run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)
                run.font.name = 'Helvetica Neue'
        set_cell_shading(cell, '1a1a1a')
    # Rows
    for r_idx, row_data in enumerate(rows):
        for c_idx, val in enumerate(row_data):
            cell = table.rows[r_idx + 1].cells[c_idx]
            cell.text = val
            for p in cell.paragraphs:
                for run in p.runs:
                    run.font.size = Pt(10)
                    run.font.name = 'Helvetica Neue'
            if r_idx % 2 == 1:
                set_cell_shading(cell, 'f5f5f5')
    # Bordes
    tbl = table._tbl
    tblPr = tbl.tblPr if tbl.tblPr is not None else OxmlElement('w:tblPr')
    borders = OxmlElement('w:tblBorders')
    for border_name in ['top', 'left', 'bottom', 'right', 'insideH', 'insideV']:
        border = OxmlElement(f'w:{border_name}')
        border.set(qn('w:val'), 'single')
        border.set(qn('w:sz'), '4')
        border.set(qn('w:space'), '0')
        border.set(qn('w:color'), 'cccccc')
        borders.append(border)
    tblPr.append(borders)
    doc.add_paragraph()
    return table

def add_highlight_box(lines, border_color='1a1a1a'):
    for line in lines:
        p = doc.add_paragraph()
        pPr = p._p.get_or_add_pPr()
        pBdr = OxmlElement('w:pBdr')
        left = OxmlElement('w:left')
        left.set(qn('w:val'), 'single')
        left.set(qn('w:sz'), '24')
        left.set(qn('w:space'), '8')
        left.set(qn('w:color'), border_color)
        pBdr.append(left)
        pPr.append(pBdr)
        # Shading
        shd = OxmlElement('w:shd')
        shd.set(qn('w:fill'), 'f7f7f7')
        shd.set(qn('w:val'), 'clear')
        pPr.append(shd)
        if line.startswith('**') and '**' in line[2:]:
            # Parsear negrita simple
            parts = line.split('**')
            for i, part in enumerate(parts):
                if part:
                    run = p.add_run(part)
                    run.bold = (i % 2 == 1)
                    run.font.size = Pt(11)
                    run.font.name = 'Helvetica Neue'
        else:
            run = p.add_run(line)
            run.font.size = Pt(11)
            run.font.name = 'Helvetica Neue'
        p.paragraph_format.space_after = Pt(2)

def add_page_break():
    doc.add_page_break()

# ============================================================
# PORTADA
# ============================================================
for _ in range(4):
    doc.add_paragraph()

add_para('GASTROTOTEM', bold=True, size=36, alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
add_para('SERVICIOS PARA GASTRONOMIA', size=11, color=(0x66, 0x66, 0x66), alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=30)

# Línea separadora
p = doc.add_paragraph()
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run('_' * 60)
run.font.color.rgb = RGBColor(0xcc, 0xcc, 0xcc)
run.font.size = Pt(8)

add_para('Gastrototem 2.0', bold=True, size=22, alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=6)
add_para('Propuesta de Modelo de Negocio, Tecnologia y Marketing', size=14, color=(0x44, 0x44, 0x44), alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=40)

add_para('Elaborado por Juanma Agrela', size=12, alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
add_para('Abril 2026', size=12, color=(0x66, 0x66, 0x66), alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
add_para('Para revision de Fernando Huidobro', size=12, color=(0x66, 0x66, 0x66), alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=30)

add_para('DOCUMENTO INTERNO \u00b7 CONFIDENCIAL', size=9, color=(0x99, 0x99, 0x99), alignment=WD_ALIGN_PARAGRAPH.CENTER)

add_page_break()

# ============================================================
# INDICE
# ============================================================
add_heading_styled('Indice', level=1)
indice = [
    '1. Por que este documento',
    '2. Diagnostico de situacion actual',
    '3. El modelo propuesto: dos productos, una identidad',
    '4. Estructura comercial con Mazzocco Gourmet',
    '5. La operativa real: como funciona una sesion',
    '6. Las herramientas tecnologicas',
    '7. Estrategia de marketing, SEO y publicidad',
    '8. Proyeccion economica',
    '9. Hoja de ruta de implementacion',
    '10. Decisiones que requieren tu opinion',
]
for item in indice:
    add_para(item, size=12, space_after=8)

add_page_break()

# ============================================================
# SECCION 1
# ============================================================
add_heading_styled('1. Por que este documento', level=1)

add_para('Fernando, este documento recoge el resultado de un analisis en profundidad del modelo Gastrototem 2.0 que hemos ido definiendo juntos. Lo he trabajado para poner sobre la mesa los numeros reales, las oportunidades y los riesgos, y proponerte un modelo concreto que podamos validar, ajustar y ejecutar.', size=12)

add_para('Necesito tu opinion sobre todo lo que leas aqui. No es un documento cerrado \u2014 es una propuesta para que la discutamos y la mejoremos entre los dos antes de dar el primer paso.', size=11)

add_para('Al final del documento hay una seccion especifica con las decisiones que necesitan tu input.', size=11)

# ============================================================
# SECCION 2
# ============================================================
add_heading_styled('2. Diagnostico de situacion actual', level=1)

add_heading_styled('Donde estamos', level=2)
add_bullet('El PACG esta paralizado por falta de financiacion. El 70% de nuestra facturacion historica ha desaparecido temporalmente. Estamos trabajando en nuevas propuestas para la Fundacion Unicaja, pero eso no resuelve el corto plazo.', bold_prefix='')
add_bullet('Mantenemos clientes del modelo antiguo (tarifas planas, gestion de redes) que consumen horas sin rentabilidad proporcional.', bold_prefix='')
add_bullet('El nuevo modelo no esta en marcha aun. Tenemos la vision, tenemos el criterio, pero no tenemos la operativa montada ni los clientes del nuevo formato.', bold_prefix='')

add_highlight_box([
    '**La realidad:** La diversificacion de ingresos ya no es un objetivo a 18 meses. Es una urgencia. Las sesiones de afinacion no son un complemento del PACG \u2014 son el motor principal ahora mismo.'
], border_color='e67e22')

add_heading_styled('Lo que tenemos a favor', level=2)
add_bullet('Tu autoridad como critico y Presidente de Honor de la Academia Andaluza de Gastronomia es un activo real que el mercado reconoce.')
add_bullet('Mas de 80.000 seguidores combinados entre tus canales y Gastrohunter.')
add_bullet('La relacion con Mazzocco Gourmet nos da acceso directo a una cartera de restaurantes en Malaga sin coste de adquisicion.')
add_bullet('Tu resides en Malaga, que es el territorio de arranque. Yo estoy a 1,5h en Granada.')

add_page_break()

# ============================================================
# SECCION 3
# ============================================================
add_heading_styled('3. El modelo propuesto: dos productos, una identidad', level=1)

add_para('La propuesta es lanzar dos productos diferenciados, no dos versiones del mismo servicio. Cada uno tiene su canal, su precio y su funcion dentro del modelo.', size=12)

add_heading_styled('Producto 1 \u2014 Sesion de Afinacion', level=2)

add_highlight_box([
    '**Precio:** 1.000 \u20ac + IVA',
    '**Canal:** Abierto (web, publicidad, organico, Mazzocco)',
    '**Funcion:** Motor principal de facturacion',
])

add_para('Que incluye:', bold=True)
add_bullet('Visita de incognito al restaurante como clientes reales (2h, compartiendo platos para probar el maximo de la carta)')
add_bullet('Informe de Afinacion PDF generado con asistencia de IA y revisado por ambos socios (2-3 paginas)')
add_bullet('Reunion inmediata con la propiedad (1h maximo) para presentar el informe con propuestas de mejora')
add_bullet('Llamada de control a 30 dias (10 minutos)')

add_para('Que NO incluye:', bold=True)
add_bullet('Segunda visita (se contrata y paga como sesion nueva)')
add_bullet('Visibilidad en nuestros canales (se otorga solo si el criterio lo justifica, nunca se vende)')
add_bullet('Ningun servicio de agencia: ni redes, ni web, ni consultoria financiera')

add_heading_styled('Producto 2 \u2014 Programa de Afinacion en Profundidad', level=2)

add_highlight_box([
    '**Precio:** 3.500 \u20ac + IVA',
    '**Canal:** Exclusivo Mazzocco Gourmet, maximo 1 cliente/mes',
    '**Funcion:** Producto de prestigio con margen superior',
])

add_para('Que incluye:', bold=True)
add_bullet('Visita 1: Sesion de afinacion completa (identica al producto estandar)', bold_prefix='')
add_bullet('Visita 2 (a los 30-45 dias): Control de implementacion. Visita pactada (no de incognito). 2 horas maximo. Se revisa en sala y cocina lo que se recomendo. Informe de seguimiento breve (1 pagina).', bold_prefix='')
add_bullet('Visita 3 (a los 60-90 dias): Nueva visita de incognito para verificar la evolucion. Informe comparativo antes/despues (2-3 paginas). Documenta la transformacion.', bold_prefix='')
add_bullet('Veredicto final firmado por ambos socios. Si es positivo, se otorga visibilidad en canales de Gastrototem como reconocimiento publico.', bold_prefix='')

add_rich_para([
    ('Pago: ', True, False, 11, None),
    ('Gastrototem cobra el 100% al confirmar la reserva de la Visita 1. El cliente puede fraccionar en 3 pagos a traves de Klarna (nosotros recibimos el total al momento, Klarna asume el riesgo de impago).', False, False, 11, None),
])

add_heading_styled('Por que dos productos y no solo uno', level=2)

add_para('La Sesion de Afinacion es el motor. Es lo que nos da volumen, marca y rentabilidad. El Programa en Profundidad existe porque:')
add_bullet('Tu quieres ofrecerlo, y tiene sentido para los clientes top de Mazzocco.')
add_bullet('El informe comparativo antes/despues es un entregable que nadie mas ofrece en el mercado andaluz.')
add_bullet('La posibilidad de obtener visibilidad publica de Gastrototem tras el programa es un incentivo potente para restaurantes que buscan reconocimiento.')
add_bullet('A nivel de rentabilidad por hora, rinde mas que la sesion estandar (como veras en la seccion 8).')

add_para('Pero es importante que el premium no nos distraiga. Maximo 1 al mes. Si la sesion estandar funciona bien, no necesitamos forzar el paquete de 3.500 \u20ac.')

add_page_break()

# ============================================================
# SECCION 4
# ============================================================
add_heading_styled('4. Estructura comercial con Mazzocco Gourmet', level=1)

add_heading_styled('Como funciona la relacion', level=2)
add_bullet('Mazzocco presenta el servicio a sus clientes restaurantes en sus visitas comerciales habituales.')
add_bullet('Cuando un restaurante muestra interes, Mazzocco le pasa el enlace de reserva de nuestra web.')
add_bullet('El cliente paga siempre a Gastrototem a traves de nuestra web. Mazzocco no factura al cliente por nuestro servicio.', bold_prefix='')
add_bullet('Mazzocco tiene un enlace o codigo de referido para trackear que clientes vienen por su canal y liquidar comisiones.')

add_heading_styled('Comisiones propuestas', level=2)

add_table(
    ['Producto', 'Precio', 'Comision Mazzocco', 'Neto Gastrototem'],
    [
        ['Sesion de Afinacion', '1.000 \u20ac', '10% = 100 \u20ac', '900 \u20ac'],
        ['Programa Premium', '3.500 \u20ac', '15% = 525 \u20ac', '2.975 \u20ac'],
    ]
)

add_highlight_box([
    '**Por que comision y no intercambio de valor:** Sin incentivo economico directo, el interes comercial de Mazzocco se diluye con el tiempo. La comision diferenciada (10% estandar, 15% premium) les incentiva a mover ambos productos, y especialmente el de mayor ticket. Es lo que convierte a Mazzocco en un canal activo, no en una buena intencion.'
])

add_heading_styled('Condiciones clave', level=2)
add_bullet('Comision pagada a 30 dias del cobro al cliente.')
add_bullet('Los clientes que llegan por web/ads propios de Gastrototem no generan comision, aunque sean clientes de Mazzocco como distribuidora.')
add_bullet('Mazzocco no tiene exclusividad geografica. Tiene prioridad comercial en Malaga por la relacion.')
add_bullet('Gastrototem mantiene independencia total de criterio. Si un producto que Mazzocco distribuye es malo, se dice en el informe. Sin excepciones.', bold_prefix='')

add_heading_styled('Que necesita Mazzocco de nosotros', level=2)
add_bullet('Un one-pager PDF profesional con el servicio explicado y el argumentario adaptado a su contexto comercial.')
add_bullet('Su enlace/codigo de referido configurado.')
add_bullet('Nada mas. No les cargamos de complejidad.')

add_page_break()

# ============================================================
# SECCION 5
# ============================================================
add_heading_styled('5. La operativa real: como funciona una sesion', level=1)

add_para('Uno de los cambios fundamentales de esta propuesta es la optimizacion radical del tiempo por sesion. El modelo del Manual Estrategico estimaba 10-15 horas por sesion. Con las herramientas tecnologicas que propongo, bajamos a 4-5,5 horas.', size=12)

add_heading_styled('Flujo completo de una Sesion de Afinacion', level=2)

add_rich_para([('1. El cliente reserva (sin intervencion nuestra)', True, False, 12, None)])
add_para('Entra en la web, ve nuestra disponibilidad geografica y horaria en el calendario, rellena el formulario pre-visita con informacion sobre su restaurante, paga por Stripe y recibe confirmacion automatica. Nosotros recibimos notificacion y los datos.')

add_rich_para([('2. Pre-visita (30 minutos)', True, False, 12, None)])
add_para('Leemos el formulario del cliente. Consultamos su web, redes sociales y presencia en Google/TripAdvisor. Hacemos la reserva en el restaurante para el dia acordado. No invertimos mas tiempo que eso.')

add_rich_para([('3. Dia de la sesion: la comida (2 horas)', True, False, 12, None)])
add_para('Vamos como clientes reales. Compartimos platos para probar el maximo posible de la carta. Mientras comemos, vamos rellenando la app de notas en el movil: valoraciones rapidas, comentarios, fotos de cada plato, notas de voz. Es discreto y rapido \u2014 parece que estamos mirando el movil como cualquier comensal.')

add_rich_para([('4. Generacion del informe (5 minutos)', True, False, 12, None)])
add_para('Al terminar la comida, completamos el veredicto rapido en la app (3 cosas buenas, 3 cosas a cambiar, 1 frase de veredicto). Pulsamos "Generar Informe". La IA produce el borrador completo en 1-2 minutos a partir de nuestras notas, fotos y valoraciones. Lo revisamos, ajustamos y confirmamos. PDF listo.')

add_rich_para([('5. Reunion con la propiedad (1 hora maximo)', True, False, 12, None)])
add_para('Nos sentamos con el propietario/gerente. Le presentamos el informe. Le explicamos nuestras observaciones y propuestas de mejora. Sin condescendencia, con criterio. Se lo entregamos y nos vamos.')

add_rich_para([('6. Control a 30 dias (10 minutos)', True, False, 12, None)])
add_para('Llamada breve para revisar que acciones ha implementado y resolver dudas. Si quiere que volvamos, contrata una nueva sesion.')

add_heading_styled('Tiempo total real', level=2)

add_table(
    ['Fase', 'Horas'],
    [
        ['Pre-visita', '0,5h'],
        ['Desplazamiento (Malaga provincia)', '0-1,5h'],
        ['Comida de incognito', '2h'],
        ['Generacion y revision del informe', '0,5h'],
        ['Reunion con propiedad', '1h'],
        ['Llamada control 30 dias', '0,15h'],
        ['TOTAL POR SESION', '4-5,5h'],
    ]
)

add_highlight_box([
    '**El dato clave:** A 1.000 \u20ac por sesion y 4-5,5 horas de trabajo real, la rentabilidad es de 182-250 \u20ac/hora. Eso es lo que vale nuestro criterio cuando dejamos de perder tiempo en tareas que la tecnologia puede resolver.'
], border_color='27ae60')

add_page_break()

# ============================================================
# SECCION 6
# ============================================================
add_heading_styled('6. Las herramientas tecnologicas', level=1)

add_para('La rentabilidad del modelo depende de tres herramientas integradas en nuestra web. Sin ellas, volvemos a las 10-15 horas por sesion y los numeros no cuadran. La buena noticia: ya tengo una app similar construida que podemos adaptar.', size=12)

add_heading_styled('Herramienta 1: Sistema de reserva online', level=2)
add_para('Integrado en gastrototem.com. Permite al cliente reservar y pagar sin que nosotros intervengamos.')
add_bullet('Calendario con nuestra disponibilidad por zona (Malaga capital, Costa del Sol, interior) y horario (comida/cena)')
add_bullet('Formulario pre-visita que el cliente rellena al reservar (datos del restaurante, concepto, retos, que quiere que observemos)')
add_bullet('Pago integrado con Stripe (sesion estandar) y Klarna (fraccionamiento del premium)')
add_bullet('Emails automaticos: confirmacion, recordatorio 48h antes')
add_bullet('Panel de administracion para gestionar agenda, ver datos de clientes e historial')

add_heading_styled('Herramienta 2: App de notas en vivo', level=2)
add_para('Interfaz movil que usamos durante la comida para registrar todo lo que observamos. Es la pieza que elimina las 3-4 horas de redaccion posterior.')
add_bullet('Se abre desde el movil con la sesion del dia cargada (datos del formulario pre-visita ya disponibles)')
add_bullet('Registro por bloques: llegada/entorno, platos (con foto y valoracion de cada uno), servicio de sala, experiencia global, veredicto rapido')
add_bullet('Notas de voz con transcripcion automatica (mas rapido que teclear)')
add_bullet('Foto de cada plato integrada \u2014 se vincula a las notas y se incluye en el informe')
add_bullet('Ambos podemos editar la misma sesion desde nuestros moviles simultaneamente')
add_bullet('Funciona sin conexion y sincroniza al recuperarla')

add_heading_styled('Herramienta 3: Motor de informes con IA', level=2)
add_para('Transforma nuestras notas en el Informe de Afinacion PDF, listo para presentar en la reunion.')
add_bullet('Toma todas las notas, valoraciones, transcripciones de voz y fotos de la app')
add_bullet('Genera el borrador completo en 1-2 minutos siguiendo nuestra plantilla')
add_bullet('Tono de critica gastronomica profesional: directo, fundamentado, sin florituras')
add_bullet('Incluye fotos de platos cuando hay algo que destacar o corregir')
add_bullet('Nosotros revisamos, ajustamos y confirmamos')
add_bullet('PDF con identidad visual Gastrototem, listo en minutos')

add_highlight_box([
    '**Importante:** La IA no sustituye nuestro criterio. Solo nos ahorra el trabajo de redaccion. Las observaciones, los juicios y las acciones propuestas son nuestras. La IA las convierte en un documento profesional a partir de lo que hemos registrado durante la comida.'
])

add_page_break()

# ============================================================
# SECCION 7
# ============================================================
add_heading_styled('7. Estrategia de marketing, SEO y publicidad', level=1)

add_para('Presupuesto limitado, territorio acotado, producto de alto ticket. No necesitamos volumen \u2014 necesitamos entre 6 y 10 solicitudes cualificadas al mes para llenar la agenda. Cada euro invertido debe estar geolocalizado en Malaga y dirigido a propietarios de restaurantes.', size=12)

add_heading_styled('Canales de adquisicion de clientes', level=2)

add_table(
    ['Canal', 'Funcion', 'Coste mensual'],
    [
        ['Mazzocco Gourmet', 'Acceso directo a su cartera de restaurantes', '0 \u20ac (comision por resultado)'],
        ['Google Ads', 'Capturar propietarios que ya buscan ayuda', '100-150 \u20ac'],
        ['Meta Ads', 'Generar demanda en propietarios que aun no buscan', '150-200 \u20ac'],
        ['SEO + Blog /criterio', 'Posicionamiento organico a medio plazo', '0 \u20ac (contenido propio)'],
        ['Instagram + LinkedIn', 'Marca y autoridad', '0 \u20ac (contenido del trabajo real)'],
    ]
)

add_heading_styled('Google Ads \u2014 Capturar demanda existente', level=2)
add_bullet('Geolocalizado exclusivamente en provincia de Malaga')
add_bullet('Keywords: "consultor gastronomico Malaga", "asesor restaurantes Malaga", "mejorar restaurante Malaga"')
add_bullet('Landing: pagina /afinacion con sistema de reserva directo')
add_bullet('Coste por lead estimado: 30-50 \u20ac')

add_heading_styled('Meta Ads \u2014 Generar demanda', level=2)
add_bullet('Segmentacion: propietarios/gerentes con intereses en hosteleria, ubicacion Malaga, edad 30-60')
add_bullet('Campana 1 (60% del presupuesto): Awareness \u2014 contenido de valor con observaciones reales anonimizadas')
add_bullet('Campana 2 (40% del presupuesto): Conversion \u2014 retargeting a quienes ya interactuaron o visitaron la web')

add_heading_styled('SEO y contenido organico', level=2)
add_bullet('Blog /criterio: 2 articulos/mes orientados a propietarios con problemas que nosotros resolvemos')
add_bullet('Contenido en redes: 3 posts/semana Instagram, 1-2 LinkedIn. Todo del trabajo real, sin produccion adicional')
add_bullet('Google Business Profile optimizado')

add_heading_styled('Inversion total en marketing', level=2)
add_highlight_box([
    '**250-350 \u20ac/mes** en publicidad de pago (3.000-4.200 \u20ac/ano)',
    'Objetivo: 6-9 leads/mes, conversion 40%, 2-4 clientes via ads',
    'Los clientes de Mazzocco son adicionales a estos numeros.',
])

add_page_break()

# ============================================================
# SECCION 8
# ============================================================
add_heading_styled('8. Proyeccion economica', level=1)

add_heading_styled('Rentabilidad por hora de cada producto', level=2)

add_table(
    ['Producto', 'Precio', 'Horas', '\u20ac/hora', '\u20ac/hora (con comision)'],
    [
        ['Sesion de Afinacion', '1.000 \u20ac', '4-5,5h', '182-250 \u20ac', '164-225 \u20ac'],
        ['Programa Premium', '3.500 \u20ac', '10-14h', '250-350 \u20ac', '213-298 \u20ac'],
    ]
)

add_heading_styled('Escenarios de facturacion', level=2)

add_table(
    ['Escenario', 'Sesiones/mes', 'Premium/mes', 'Bruto mensual', 'Bruto anual', 'Horas/semana'],
    [
        ['Conservador', '4', '0', '4.000 \u20ac', '48.000 \u20ac', '4-5,5h'],
        ['Objetivo', '4', '1', '7.500 \u20ac', '90.000 \u20ac', '6,5-9h'],
        ['Optimo', '6', '1', '9.500 \u20ac', '114.000 \u20ac', '8,5-12h'],
    ]
)

add_heading_styled('Retorno sobre la inversion en marketing', level=2)

add_table(
    ['Metrica', 'Mensual', 'Anual'],
    [
        ['Inversion en ads', '250-350 \u20ac', '3.000-4.200 \u20ac'],
        ['Clientes via ads (conversion 40%)', '2-4', '24-48'],
        ['Facturacion generada por ads', '2.000-4.000 \u20ac', '24.000-48.000 \u20ac'],
        ['ROI', '6x-16x', '6x-16x'],
    ]
)

add_highlight_box([
    '**Comparativa con el PACG:** En el escenario objetivo (4 sesiones + 1 premium/mes), la facturacion anual de 90.000 \u20ac supera ampliamente lo que el PACG nos aportaba. Y lo hace con menos horas de trabajo y sin depender de la voluntad politica ni de ciclos electorales.'
], border_color='27ae60')

add_heading_styled('Politica de precios a largo plazo', level=2)
add_para('El precio de 1.000 \u20ac es el precio de arranque. Si la demanda supera consistentemente la oferta (mas de 4 solicitudes no atendidas durante dos meses consecutivos), el precio sube a 1.200 \u20ac o 1.500 \u20ac.')
add_rich_para([('La regla: nunca se aumentan los dias trabajados, solo el precio por dia.', True, False, 11, None)])

add_page_break()

# ============================================================
# SECCION 9
# ============================================================
add_heading_styled('9. Hoja de ruta de implementacion', level=1)

add_heading_styled('Fase 1 \u2014 Cimientos (Mes 1-2)', level=2)
add_bullet('Desarrollo de las tres herramientas tecnologicas (app de reserva, app de notas, motor de informes)')
add_bullet('Rediseno de gastrototem.com con el nuevo posicionamiento')
add_bullet('Actualizacion de bios en Instagram y LinkedIn')
add_bullet('Configuracion del sistema de reserva y pago (Stripe + Klarna)')
add_bullet('Creacion del one-pager para Mazzocco')
add_bullet('Formalizacion del acuerdo comercial con Mazzocco (comisiones, condiciones)')

add_heading_styled('Fase 2 \u2014 Lanzamiento (Mes 2-3)', level=2)
add_bullet('2 sesiones piloto con restaurantes de confianza para calibrar la operativa y las herramientas')
add_bullet('Anuncio oficial del servicio en Instagram y LinkedIn')
add_bullet('Lanzamiento de Google Ads y Meta Ads geolocalizados en Malaga')
add_bullet('Mazzocco empieza a presentar el servicio a sus clientes')
add_bullet('Inicio del plan de contenido: 3 publicaciones/semana')

add_heading_styled('Fase 3 \u2014 Velocidad de crucero (Mes 3 en adelante)', level=2)
add_bullet('4 sesiones estandar/mes como objetivo operativo')
add_bullet('1 programa premium/mes (cuando Mazzocco lo active)')
add_bullet('1 caso de trabajo publicado/mes (con permiso del cliente)')
add_bullet('Blog /criterio: 2 articulos/mes')
add_bullet('Revision trimestral: que canal genera mas solicitudes, ajustar inversion')

add_page_break()

# ============================================================
# SECCION 10
# ============================================================
add_heading_styled('10. Decisiones que requieren tu opinion', level=1)

add_para('Fernando, necesito tu feedback sobre los siguientes puntos antes de avanzar con la implementacion.', size=12)

preguntas = [
    ('1. Sobre el Programa Premium',
     'La propuesta diferencia la Visita 2 de las demas: no es de incognito, es una visita de control pactada de 2 horas sin comida completa. Esto es lo que hace que el paquete rinda mas por hora que la sesion estandar. \u00bfEstas de acuerdo con este formato o prefieres que las tres visitas sean incognito completas?'),
    ('2. Sobre las comisiones de Mazzocco',
     'Propongo 10% en sesion estandar y 15% en premium. La alternativa de intercambio de valor (sin comision) genera riesgo de que Mazzocco pierda interes con el tiempo. \u00bfVes estos porcentajes razonables o quieres proponer otros?'),
    ('3. Sobre el territorio',
     'Propongo arrancar exclusivamente en provincia de Malaga y activar Granada cuando la demanda lo justifique. \u00bfEstas de acuerdo o quieres incluir Granada desde el inicio?'),
    ('4. Sobre la independencia de criterio con Mazzocco',
     'He incluido explicitamente que si detectamos problemas en productos que Mazzocco distribuye, lo decimos en el informe con el mismo rigor. \u00bfHas hablado de esto con ellos? \u00bfLo ven claro?'),
    ('5. Sobre el contenido del Programa Premium',
     'La propuesta actual cubre cocina, sala, experiencia y coherencia. Tu mencionaste que el premium seria "mas completo". \u00bfHay areas adicionales que quieras incluir que no esten contempladas aqui?'),
    ('6. Sobre los clientes del modelo antiguo',
     'El plan implica liberar las horas que dedicamos a tarifas planas y gestion de redes. \u00bfTienes clientes activos que debamos migrar o dar de baja antes de arrancar?'),
]

for titulo, texto in preguntas:
    add_heading_styled(titulo, level=2)
    add_para(texto)
    # Espacio para respuesta
    add_para('')
    p = doc.add_paragraph()
    run = p.add_run('Tu opinion:')
    run.font.size = Pt(11)
    run.font.italic = True
    run.font.color.rgb = RGBColor(0x99, 0x99, 0x99)
    run.font.name = 'Helvetica Neue'
    p.paragraph_format.space_after = Pt(4)
    # Líneas para escribir
    for _ in range(3):
        p = doc.add_paragraph()
        run = p.add_run('_' * 80)
        run.font.color.rgb = RGBColor(0xdd, 0xdd, 0xdd)
        run.font.size = Pt(9)
        p.paragraph_format.space_after = Pt(8)

# Cita final
add_para('')
add_para('')
p = doc.add_paragraph()
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run('\u00abLa era de la agencia 360 ha terminado.\nComienza la era de la Alta Afinacion Gastronomica.\u00bb')
run.font.size = Pt(16)
run.font.italic = True
run.font.name = 'Helvetica Neue'
run.font.color.rgb = RGBColor(0x33, 0x33, 0x33)

# Footer
add_para('')
p = doc.add_paragraph()
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run('GASTROTOTEM S.L. \u2014 B90123514 | C/ Bartolome de Medina 24 B | 41004 Sevilla')
run.font.size = Pt(9)
run.font.color.rgb = RGBColor(0x99, 0x99, 0x99)
run.font.name = 'Helvetica Neue'

p = doc.add_paragraph()
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run('Documento interno \u00b7 Abril 2026')
run.font.size = Pt(9)
run.font.color.rgb = RGBColor(0x99, 0x99, 0x99)
run.font.name = 'Helvetica Neue'

# Guardar
output_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'Gastrototem_2.0_Propuesta_Modelo_Negocio.docx')
doc.save(output_path)
print(f'Documento generado: {output_path}')
