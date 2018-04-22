# coding: utf-8
import sys
import pandas as pd
import olap.xmla.xmla as xmla
from StringIO import StringIO

def xmlamembers2list(itrbl):
    result = []
    
    for member in itrbl:
        if isinstance(member, list):
            label = u''
            member_it = iter(member)
            s = [None]
            
            while member_it:
                try:
                    low_member = next(member_it)
                    if isinstance(low_member, list):
                        s.append(member_it)
                        member_it = iter(low_member)
                    else:
                        label += u'{} '.format(low_member.Caption)
                except StopIteration:
                    member_it = s.pop()
            
            label = label[:-1]
        else:
            label = member.Caption
            
        result.append(label)
    
    return result

url = sys.argv[1]
user = sys.argv[2]
passw = sys.argv[3]
catalog = sys.argv[4]
mdx_str = sys.argv[5]

p = xmla.XMLAProvider()
c = None

try:
    c = p.connect(location=url, username=user, password=passw)
    mdx_res = c.Execute(mdx_str, Catalog=catalog)
except: pass

if c:
    try: c.EndSession()
    except: pass

mdx_cols = xmlamembers2list(mdx_res.getAxisTuple(axis=0))
mdx_rows = xmlamembers2list(mdx_res.getAxisTuple(axis=1))
mdx_data = [[x.FmtValue if hasattr(x, 'FmtValue') else '0' for x in cell] for cell in mdx_res.getSlice()]
mdx_df = pd.DataFrame(mdx_data,
    columns=mdx_cols, index=pd.Index(mdx_rows, name='ID'))
mdx_csv_str = StringIO()
mdx_df.to_csv(mdx_csv_str)
print(mdx_csv_str.getvalue())
