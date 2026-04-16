import pandas as pd
import numpy as np
import os

# تعيين المسار الأساسي للمشروع (جذر المشروع C:\myproject)
# الملف موجود في C:\myproject\ml_models، لذا نعود مستويين للأعلى
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
# تعيين مسارات الملفات بناءً على BASE_DIR
COMPANY_FILE = os.path.join(BASE_DIR, "storage", "app", "company_location.csv")
STUDENTS_FILE = os.path.join(BASE_DIR, "storage", "app", "students_locations.csv")
OUTPUT_FILE = os.path.join(BASE_DIR, "storage", "app", "closest_students.csv")

# التأكد من وجود المجلد storage/app، وإنشاؤه إذا لم يكن موجودًا
output_dir = os.path.dirname(OUTPUT_FILE)
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# دالة لحساب المسافة باستخدام صيغة Haversine
def haversine(lat1, lon1, lat2, lon2):
    # نصف قطر الأرض بالكيلومترات
    R = 6371.0
    
    # تحويل الدرجات إلى راديان
    lat1_rad = np.radians(lat1)
    lon1_rad = np.radians(lon1)
    lat2_rad = np.radians(lat2)
    lon2_rad = np.radians(lon2)
    
    # الفرق في الإحداثيات
    dlat = lat2_rad - lat1_rad
    dlon = lon2_rad - lon1_rad
    
    # صيغة Haversine
    a = np.sin(dlat / 2)**2 + np.cos(lat1_rad) * np.cos(lat2_rad) * np.sin(dlon / 2)**2
    c = 2 * np.arctan2(np.sqrt(a), np.sqrt(1 - a))
    distance = R * c
    
    return distance

# قراءة بيانات الشركة والطلاب
try:
    company_df = pd.read_csv(COMPANY_FILE)
    students_df = pd.read_csv(STUDENTS_FILE)
except FileNotFoundError as e:
    print(f"Error: File not found - {e}")
    exit(1)
except Exception as e:
    print(f"Error reading files: {e}")
    exit(1)

# التأكد من أن لدينا بيانات
if company_df.empty:
    print("No company data found")
    exit(1)
if students_df.empty:
    print("No student data found")
    exit(1)

# التأكد من أن الإحداثيات موجودة وصالحة
if not all(col in company_df.columns for col in ['lat', 'lon']) or not all(col in students_df.columns for col in ['lat', 'lon']):
    print("Coordinates are missing in the data")
    exit(1)

# موقع الشركة
company_lat, company_lon = company_df.iloc[0]['lat'], company_df.iloc[0]['lon']

# التأكد من أن الإحداثيات صالحة
if pd.isna(company_lat) or pd.isna(company_lon):
    print("Invalid company coordinates")
    exit(1)

# إزالة الطلاب الذين لديهم إحداثيات غير صالحة
students_df = students_df.dropna(subset=['lat', 'lon'])

if students_df.empty:
    print("No students with valid coordinates")
    exit(1)

# حساب المسافة بين الشركة وكل طالب
students_df['distance_km'] = students_df.apply(
    lambda row: haversine(company_lat, company_lon, row['lat'], row['lon']),
    axis=1
)

# ترتيب الطلاب حسب المسافة وأخذ أقرب 10
closest_students = students_df.sort_values(by='distance_km').head(10)

# التأكد من أن لدينا نتائج
if closest_students.empty:
    print("No students to display after calculation")
    exit(1)

# حفظ النتائج
try:
    closest_students.to_csv(OUTPUT_FILE, index=False)
    print(f"Successfully saved the top 10 closest students to {OUTPUT_FILE}")
except Exception as e:
    print(f"Error saving results: {e}")
    exit(1)